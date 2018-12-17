<?php

namespace App\DAL;
use App\Models\UserDirectory;
use App\Models\UserParentDirectory;
use App\Models\UserDocuments;
use App\Models\UserSignatures;
use App\DAL\CommonRepository as common;
use App\User;
use Auth;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;
use Stevenmaguire\OAuth2\Client\Provider\Dropbox;
use Illuminate\Support\Facades\Session;

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
            $signatures = $this->getUserSignatures('true');

            $response = array($this->common->success => true);
            $response['data']['folders'] = $folders;
            $response['data']['documents'] = $documents;
            $response['data']['signatures'] = $signatures;

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
            //$signatures = User::where('id', $userId)->find(1)->userSignatures()->get();
            $response = array($this->common->success => true);

            $response['data']['folders'] = $folders;
            $response['data']['documents'] = $documents;
            //$response['data']['signatures'] = $signatures;

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
            $id = (int)$data['id'];
            $saveData['user_id'] = $userId;
            $saveData['name'] = trim($data['name']);
            $parentFolderId = (int)$data['parentId'];

            // CHECK IF FOLDER NAME ALREADY EXISTS.
            $isDirectoryExists = $this->isDirectoryExists($userId,$id,$parentFolderId,$data['name']);

            if (!$isDirectoryExists) {
                try {
                    Db::beginTransaction();

                    if ($id) {
                        //check whether folder name alrady exist on current folder directory
                        $message = 'Folder updated successfully.';
                        $saveData['updated_at'] = Carbon::now();
                        parent::update($saveData, $id);

                    } else {
                        $message = 'Folder created successfully.';
                        $saveData['created_at'] = Carbon::now();
                        $insertedFolder = parent::create($saveData);

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
            } else {
                $response = array($this->common->success => false, 'error' => ['statusCode' => 103, 'message' => 'Validation errors in your request.', 'errorDescription' => ['Folder name already exists. Please try another.']]);
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
        $validator = $this->validateFileUpload($data);

        //VALIDATION FUNCTION
        if ($validator->fails()) {
            $response = array($this->common->success => false, 'error' => ['statusCode' => 103, 'message' => 'Validation errors in your request.', 'errorDescription' => $validator->errors()]);
        } else {
            try {

                $userDirectoryId = $data['user_directory_id'];
                $isConfirmByUser = true;
                //$fileName = time() . '.' . $data['file']->getClientOriginalExtension();
                $originalName = $data['file']->getClientOriginalName();
                $fileName = $originalName;

                /* check Whether file with same name exists */
                $isDocumentExist = $this->isDocumentExists($userId,$userDirectoryId,$originalName);
                //dd($isDocumentExist);
                if($isDocumentExist){
                    $copyName = ' - copy';
                    if($isDocumentExist > 1){
                        $copyName = ' - copy(' . $isDocumentExist . ')';
                    }
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME).$copyName.'.'.$data['file']->getClientOriginalExtension();
                    //user confirmation call
                    //$response = array($this->common->success => false, 'message' => 'File Already Exist.','exist'=>true);
                }
                //dd($fileName);

                $pathToStoreFile = $userId . "/documents/" . $userDirectoryId;

                $path = Storage::disk('public')->putFileAs($pathToStoreFile, $data['file'], $fileName);
                $this->dropboxFileUpload($fileName,Storage::url($pathToStoreFile.'/'.$fileName),$pathToStoreFile);

                Db::beginTransaction();

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
    public function validateFileUpload($data,$type='')
    {
        $rule = ['file' => "required|mimes:doc,docx,pdf"];
        if($type =='pic'){
            $rule = ['file' => 'required|mimes:jpeg,jpg,png'];
        }
        return Validator::make($data,$rule,[
            'file.required' => 'File is required to upload.',
            'file.mimes'  => 'File type not supported.'
        ]);
        /*return  Validator::make($data,[
            'file' => "required|mimes:doc,docx,pdf"
        ],
            [
                'file.required' => 'File is required to upload.',
                'file.mimes'  => 'File type not supported.'
            ]);*/
    }
    public function getDocument($documentId,$folderId){
        $userId = Auth::user()->id;
        try {
            $data = [];
            Db::beginTransaction();

            $document = DB::table('user_documents as ud')
                ->where('ud.id', $documentId)
                ->where('ud.user_id', $userId)
                ->where('ud.user_directory_id', $folderId)
                ->whereNull('ud.deleted_at')->first();
            DB::commit();

            $documentPath = $document->file_path;
            $exists = Storage::disk('public')->exists($documentPath);
            if($exists){
                $data['url'] = url('/').Storage::url($documentPath);
                $data['mimeType'] = Storage::disk('public')->mimeType($documentPath);
            }
            $response = array($this->common->success => true, 'data' => $data);
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
    public function isDirectoryExists($userId,$folderId,$parentFolderId,$name){
        $count= 0;
        if($parentFolderId==0){

            $folders = DB::table('user_directory')
                ->where('user_id',$userId)
                ->where('name',$name)
                ->whereNull('deleted_at')
                ->where('id','<>',$folderId)->pluck('id')->toArray();
            $count = count($folders);
            /* IF FOUND RECORD WITH SAME NAME THEN CHECK WHETHER ITS CHILD DIRECTORY OR NOT */
            if ($count) {
                $childCount = DB::table('user_parent_directory as upd')->whereIn('user_directory_id', $folders)->count();
                if ($count === $childCount) {
                    /* ALLOW IF RECORD IS FOR CHILD DIRECTORY */
                    $count = 0;
                }
            }

        } else {
            $count = DB::table('user_parent_directory as upd')
                ->leftJoin('user_directory as ud','upd.user_directory_id','=','ud.id')
                ->select('ud.*')
                ->where('ud.user_id', $userId)
                ->where('upd.user_parent_directory_id', $parentFolderId)
                ->where('ud.id','<>', $folderId)
                ->where('ud.name', $name)
                ->whereNull('ud.deleted_at')->count();

        }
        return $count;
    }
    public function isDocumentExists($userId,$folderId,$originalName){

            $count = DB::table('user_documents as ud')
                ->where('ud.file_original_name', $originalName)
                ->where('ud.user_id', $userId)
                ->where('ud.user_directory_id', $folderId)
                ->whereNull('ud.deleted_at')->count();

        return $count;
    }
    public function createSignature($data){
        //dd($data);
        /*$hasError = false;*/
        try {
            $userId = Auth::user()->id;
            if($data['replaceSignId']){
                //remove signature
                Db::beginTransaction();

                UserSignatures::find($data['replaceSignId'])->delete();
                Db::commit();
            }
            /*if($data['type']=='upload'){
                $validator = $this->validateFileUpload($data,'pic');

                //VALIDATION FUNCTION
                if ($validator->fails()) {
                    $response = array($this->common->success => false, 'error' => ['statusCode' => 103, 'message' => 'Validation errors in your request.', 'errorDescription' => $validator->errors()]);
                    $hasError = true;
                } else {
                    $fileExt = $data['file']->getClientOriginalExtension();
                    $fileName = time().'.'.$fileExt;
                    $pathToStoreFile = $userId . "/signatures/";

                    $path = Storage::disk('public')->putFileAs($pathToStoreFile, $data['file'], $fileName);
                    $pathToStoreFile = $pathToStoreFile.$fileName;
                }
            }else{*/
                //get the base-64 from data
                $base64_str = substr($data['signatureData'], strpos($data['signatureData'], ",")+1);
                //decode base64 string
                $image = base64_decode($base64_str);
                //dd($image);
                $ext = 'png';
                if($data['fileext']){
                    $ext = $data['fileext'];
                }
                /*$f = finfo_open();
                $ext = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
                $ext = substr($ext,strpos($ext,'/')+1);*/
                $fileName = time().'.'.$ext;
                $pathToStoreFile = $userId . "/signatures/".$fileName;

                Storage::disk('public')->put($pathToStoreFile, $image);
                $this->dropboxFileUpload($fileName,Storage::url($pathToStoreFile),$userId . "/signatures/");
           /* }*/

            /*if($hasError == false){*/
                Db::beginTransaction();

                // create user signature model object to store the data
                $userSignature = new UserSignatures();
                $userSignature->user_id = $userId;
                $userSignature->file_path = $pathToStoreFile;
                $userSignature->file_name = $fileName;

                $userSignature->save();

                DB::commit();
                $message = 'Signature saved successfully.';
                $response = array($this->common->success => true, 'message' => $message);
            /*}*/

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
    public function getUserSignatures($isLocal=''){
        $signatures = [];
        try {
            $userId = Auth::user()->id;
            $signatures = User::where('id', $userId)->find(1)->userSignatures()->get();
            foreach ($signatures as $key => $signature){
                $signatures[$key]->file_path = url('/').Storage::url($signature->file_path);
                /*dd($signature->file_path);
                $path = url('/').Storage::url($signature->file_path);*/
            }
            $response = array($this->common->success => true, 'signatures' => $signatures);
        }catch (\Exception $e) {
            DB::rollBack();
            $response = array(
                $this->common->success => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            );
        }
        if($isLocal=='true')
            return $signatures;

        return Response::json($response);
    }
    /*public function uploadSignature($data){

        $userId = Auth::user()->id;
        $validator = $this->validateFileUpload($data,'pic');

        //VALIDATION FUNCTION
        if ($validator->fails()) {
            $response = array($this->common->success => false, 'error' => ['statusCode' => 103, 'message' => 'Validation errors in your request.', 'errorDescription' => $validator->errors()]);
        } else {
            try {
                $originalName = $data['file']->getClientOriginalName();
                $fileExt = $data['file']->getClientOriginalExtension();
                $fileName = time().'.'.$fileExt;
                $pathToStoreFile = $userId . "/signatures/";

                $path = Storage::disk('public')->putFileAs($pathToStoreFile, $data['file'], $fileName);

                Db::beginTransaction();

                // create user signature model object to store the data
                $userSignature = new UserSignatures();
                $userSignature->user_id = $userId;
                $userSignature->file_path = $pathToStoreFile.$fileName;
                $userSignature->file_name = $fileName;

                $userSignature->save();

                DB::commit();
                $message = 'Signature saved successfully.';
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
    }*/
    public function dropboxFileUpload($fileName,$filePath,$pathToStoreFile)
    {
        $tokenn = Session::get('dropboxToken');
        //dd($tokenn);
        //dd($tokenn);
        //$Client = new Client(config('filesystems.dropbox.access_token'));
        $Client = new Client($tokenn);
        $file = fopen(public_path($filePath), 'rb');
        $dropboxFileName = $pathToStoreFile.'/'.$fileName;
        $Client->upload($dropboxFileName,$file, 'add');
    }
    public function getAuthorizationUrl(){
        $provider = new Dropbox([
            'clientId'          => config('filesystems.dropbox.key'),
            'clientSecret'      => config('filesystems.dropbox.secret'),
            'redirectUri'       => config('filesystems.dropbox.redirect_url')
        ]);

        if (!isset($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            Session::put('oauth2state', $provider->getState());
            //return $authUrl;
            return ['authUrl' => $authUrl,'redirectUrl' => config('filesystems.dropbox.redirect_url')];
            /*return view('dropbox', ['authUrl' => $authUrl,'redirectUrl' => 'http://localhost:8000/get-auth-url']);*/
            /*header('Location: '.$authUrl);
            exit;*/

            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== Session::get('oauth2state'))) {
            //dd($_REQUEST);
            Session::forget('oauth2state');
            /*unset($_SESSION['oauth2state']);*/
            exit('Invalid state');

        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            // Optional: Now you have a token you can look up a users profile data
            /*try {

                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                // Use these details to create a new profile
                //printf('Hello %s!', $user->getId());

            } catch (Exception $e) {

                // Failed to get user details
                exit('Oh dear...');
            }*/
            $dt = $token->getToken();
            //session(['dropboxToken' => $dt]);
            //dd($token.'</br>'.$dt.'</br>'.session('dropboxToken'));
            Session::put('dropboxToken', $dt);
            // Use this to interact with an API on the users behalf
            //return $token->getToken();

        }
    }

}
