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
     * get list of assets class
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

            $response = array($this->common->success => true);

            $response['data'] = $folders;

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

            $response = array($this->common->success => true);

            $response['data'] = $folders;

        } catch (\Exception $e) {
            $response = $this->common->getErrorMessage($e->getMessage());
        }

        return Response::json($response);
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
}
