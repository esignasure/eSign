<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserParentDirectory extends Model
{
    use SoftDeletes;

    public $table = "user_parent_directory";

    protected $fillable = [
        'user_directory_id',
        'user_parent_directory_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];
}
