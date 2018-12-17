<?php

namespace App\Http\Controllers;
use App\DAL\MyFilesRepository;
use Illuminate\Http\Request;
use test\Mockery\ReturnTypeObjectTypeHint;

class MyFiles extends Controller
{
    private $myFiles;
    public function __construct(MyFilesRepository $myFilesRepository)
    {
        $this->myFiles = $myFilesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->myFiles->getFolders();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubFolders($folderId)
    {
        return $this->myFiles->getSubFolders($folderId);
    }

    /**
     * Create new user added folder
     *
     * @return mixed
     */
    public function createFolder(Request $request)
    {
        return $this->myFiles->createFolder($request->all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFolder($id)
    {
        return $this->myFiles->deleteFolder($id);
    }

    public function uploadDocument(Request $request) {
        return $this->myFiles->uploadDocument($request->all());
    }
    public function deleteDocument($id) {
        return $this->myFiles->deleteDocument($id);
    }
    public function getDocument($documentId,$folerId) {
        return $this->myFiles->getDocument($documentId,$folerId);
    }
    /**
     * Create new user signature
     *
     * @return mixed
     */
    public function createSignature(Request $request){
        return $this->myFiles->createSignature($request->all());
    }
    public function getUserSignatures(){
        return $this->myFiles->getUserSignatures();
    }
    /*public function uploadSignature (Request $request){
        return $this->myFiles->uploadSignature($request->all());
    }*/
    public function getAuthorizationUrl(){
        return $this->myFiles->getAuthorizationUrl();
    }
}
