<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocuments extends Model
{
    use SoftDeletes;

    public $table = "user_documents";

    protected $fillable = [
        'user_id',
        'user_directory_id',
        'file_name',
        'file_original_name',
        'file_path',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];
}
