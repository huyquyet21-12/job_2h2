<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;
    //vi co so du lieu dinh nghia khong co cot timestamps
    //=> bo di
    protected $fillable = [
        'name',
        'address',
        'country',
        'zipcode',
        'phone',
        'email',
        'logo',

    ];
}
