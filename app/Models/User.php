<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    //ke thua de xac dinh nguoi dung qua OAuth
    use Authenticatable;
    use HasFactory;
    use SoftDeletes;//khai bao de xoa mem

    protected $fillable = [
        'email',
        'name',
        'avatar',
        'password',
        'role',
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
        //moi quan he mot nhieu => belongsTo

    }

    public function getRoleNameAttribute()
    {
        return UserRoleEnum::getKeys($this->role)[0];
        //tra ve mang nhung chi co 1 thang => tra ve 0
    }

    public function getGender()
    {
        return ($this->gender == 0 ) ? 'Male' : 'Female';
    }

}
