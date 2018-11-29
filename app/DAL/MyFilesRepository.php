<?php

namespace App\DAL;
use App\Models\UserDirectory;
use App\Models\UserParentDirectory;
use App\Models\UserDocuments;
use App\DAL\CommonRepository as common;
use Auth;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MyFilesRepository extends Repository
{
    private $common;

    /**
     * CONSTRUCTOR
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->common = new common();
    }

    /**
     * @return string
     * to get model for repository use
     */
    function model()
    {
        return 'App\Models\UserDirectory';
    }

    /**
     * get list of all root folder
     * @return mixed
     */
    public function getFolders()
    {
        $userId = Auth::user()->id;

        try {

            $folders = DB::table('user_directory as ud')
                ->leftJoin('user_parent_directory as usd','ud.id','=','usd.user_directory_id')
                ->select('ud.id', 'ud.name', 'ud.created_at', 'ud.updated_at')
                ->where('ud.user_id', $userId)
                ->whereNull('usd.user_directory_id')
                ->whereNull('ud.deleted_at')->get();

            $documents = $this->getDocuments($userId, 0);

            $response = array($this->common->success => true);
            $response['data']['folders'] = $folders;
            $response['data']['documents'] = $documents;

        } catch (\Exception $e) {
            $response = $this->common->getErrorMessage($e->getMessage());
        }

        return Response::json($response);
    }

    /**
     * get the sub folder and files
     *
     * @param $folderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubFolders($folderId)
    {
        $userId = Auth::user()->id;
        try {

            $folders = DB::table('user_parent_directory as upd')
                ->leftJoin('user_directory as ud','upd.user_directory_id','=','ud.id')
                ->select('ud.id', 'ud.name', 'ud.created_at', 'ud.updated_at')
                ->where('ud.user_id', $userId)
                ->where('upd.user_parent_directory_id', $folderId)
                ->whereNull('ud.deleted_at')->get();

            $documents = $this->getDocuments($userId, $folderId);

            $response = array($this->common->success => true);

            $response['data']['folders'] = $folders;
            $response['data']['documents'] = $documents;

        } catch (\Exception $e) {
            $response = $this->common->getErrorMessage($e->getMessage());
        }

        return Response::json($response);
    }

    /**
     * get list of all root folder
     * @return mixed
     */
    public function getDocuments($userId, $folderId)
    {

        $documents = [];
    
        try {

            $documents = DB::table('user_documents as ud')
                ->where('ud.user_id', $userId)
                ->where('ud.user_directory_id', $folderId)
                ->whereNull('ud.deleted_at')->get();
            
        } catch (\Exception $e) {
            $response = $this->common->getErrorMessage($e->getMessage());
        }

        return $documents;
    }


    /**
     * save asset class
     * @param $data
     * @return mixed
     */
    public function createFolder($data)
    {
        $userId = Auth::user()->id;

        $validator = $this->validateCreate($data);

        //VALIDATION FUNCTION
        if ($validator->fails()) {
            $response = array($this->common->success => false, 'error' => ['statusCode' => 103, 'message' => 'Validation errors in your request.', 'errorDescription' => $validator->errors()]);

        } else {

            try {
                Db::beginTransaction();
                $saveData['name'] = trim($data['name']);
                $saveData['user_id'] = $userId;
                $parentFolderId = (int)$data['parentId'];

                $id = (int)$data['id'];

                if ($id) {
                    $message = 'Folder updated successfully.';
                    $saveData['updated_at'] = Carbon::now();
                    parent::update($saveData, $id);
                } else {
                    $message = 'Folder created successfully.';
                    $saveData['created_at'] = Carbon::now();
                    $insertedFolder  = parent::create($saveData);

                    // check if the folder has parent folder and map current folder with it's parent

                    if ($parentFolderId > 0) {
                        $folderId = (int)$insertedFolder->id;

                        $parentDirectory = new UserParentDirectory();

                        $parentDirectory->user_directory_id = $folderId;
                        $parentDirectory->user_parent_directory_id = $parentFolderId;

                        $parentDirectory->save();
                    }
                }

                DB::commit();

                $response = array($this->common->success => true, 'message' => $message);

            } catch (\Exception $e) {
                DB::rollBack();
                $response = array(
                    $this->common->success => false,
                    'error' => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ]
                );
            }

        }

        return Response::json($response);


    }

    /**
     * delete assets
     * @param $id
     * @return mixed
     */
    public function deleteFolder($id)
    {

        try {
            parent::delete($id);
            $response = array($this->common->success => true, 'message' => 'Folder deleted successfully.');

        } catch (\Exception $e) {
            $response = array(
                $this->common->success => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            );
        }

        return Response::json($response);

    }

    /**
     *  CREATE VALIDATION FUNCTION
     * @param $data
     * @return mixed
     */
    public function validateCreate($data)
    {
       /* $id = 0;
        if($data['id']){
            $id = $data['id'];
        }*/
        return  Validator::make($data,[
            //'name' => "required|unique:asset_class,name,$id"
            'name' => "required"
        ],
        [
            'name.required' => 'Folder name is required.',
            // 'name.unique'  => 'Asset class is already exists. Please try another.'
        ]);
    }

    public function uploadDocument($data){
        $userId = Auth::user()->id;
        
        try {

            $userDirectoryId = $data['user_directory_id'];
        
            $fileName = time() . '.' . $data['file']->getClientOriginalExtension();       
            $originalName = $data['file']->getClientOriginalName();
            $pathToStoreFile = $userId . "/documents/" . $userDirectoryId;

            $path = Storage::putFileAs($pathToStoreFile, $data['file'], $fileName);

                Db::beginTransaction();
            
                /*$saveData['user_directory_id'] = $userDirectoryId;
                $saveData['file_path']=$path;
                $saveData['file_name']=$fileName;
                $saveData['file_original_name']=$originalName;*/

                // create user document model objet to store the data
                $userDocument = new UserDocuments();

                $userDocument->user_id = $userId;
                $userDocument->user_directory_id = $userDirectoryId;
                $userDocument->file_path = $path;
                $userDocument->file_name = $fileName;
                $userDocument->file_original_name = $originalName;

                $userDocument->save();

                DB::commit();
                $message = 'File Uploaded successfully.';
                $response = array($this->common->success => true, 'message' => $message);

        } catch (\Exception $e) {
            DB::rollBack();
            $response = array(
                $this->common->success => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            );
        }
        return Response::json($response);
    }
     /**
     * delete Document
     * @param $id
     * @return mixed
     */
    public function deleteDocument($id)
    {
        try {
            Db::beginTransaction();
            $userDocument = new UserDocuments();
            
            /*$userDocument->deleted_at = Carbon::now();
            $userDocument->delete($id);*/
            UserDocuments::find($id)->delete();
            Db::commit();
            $response = array($this->common->success => true, 'message' => 'Document deleted successfully.');

        } catch (\Exception $e) {
            $response = array(
                $this->common->success => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            );
        }

        return Response::json($response);

    }
}
