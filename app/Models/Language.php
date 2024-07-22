<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    public $timestamps = false;
    //dung nay de khi tao seed no chay duoc

    protected $fillable = [
        'name',
    ];
}
