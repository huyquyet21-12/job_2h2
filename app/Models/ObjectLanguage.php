<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ObjectLanguage extends Model
{
    public $table = 'object_language';
    //ghi de ten bang
    public $timestamps = false;
    public $incrementing = false;//tu dong tang

    protected $fillable = [
        'object_id',
        'language_id',
        'object_type',
    ];
}
