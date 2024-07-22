<?php

use App\Enums\SystemCacheKeyEnum;
use App\Enums\UserRoleEnum;
use App\Models\Post;

if(!function_exists('getRoleByKey')){
    function getRoleByKey($key): string
    {
        return strtolower(UserRoleEnum::getKeys((int)$key)[0]);
    }
}


if (!function_exists('user')) {
    function user(): ?object
    {
        return auth()->user();
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool
    {
        return user() && user()->role === UserRoleEnum::SUPER_ADMIN;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return user() && user()->role === UserRoleEnum::ADMIN;
    }
}

if(!function_exists('getAndCachePostCities')) {
    function getAndCachePostCities():array 
    {
        return cache()->remember(
            SystemCacheKeyEnum::POST_CITIES,
            86400 * 30,
            function(){
            $cities = Post::query()
            ->pluck('city');

            $arrCity = [];
            foreach($cities as $city){
                if(empty($city)){
                    continue;
                }
                $arr = explode(', ',$city);
                foreach($arr as $item){
                    if(!empty($item)){
                        continue;
                    }
                    if(in_array($item,$arrCity)){
                        continue;
                        //neu $item da co trong $arrCity => bo qua
                    }
                    //neu chua co $item trong $arrCity => them vao
                    $arrCity[] = $item;
                }
            }
            return $arrCity;
        }
    );
    }
}




