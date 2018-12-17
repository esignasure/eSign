<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSignatures extends Model
{
    use SoftDeletes;
    public $table = "user_signatures";

    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];
    /*public function user()
    {
        return $this->belongsTo('App\User');
    }*/
}
