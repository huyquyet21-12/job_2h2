<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\checkSlugRequest;
use App\Http\Requests\Post\generateSlugRequest;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class PostController extends Controller
{
    use ResponseTrait;
    //ke thua tu controller ResponseTrait
    private object $model;

    public function __construct()
    {
        $this->model = Post::query();
    }

    public function index():JsonResponse
    {
        
        $data =  $this->model->latest()->paginate();
        foreach($data as $each) {
            // $each->append('currency_salary_code');
            //them them du lieu currency_salary_code tu ben model code
            $each->currency_salary = $each->currency_salary_code;
            $each->status = $each->status_name;
        }

        //getCollection va linkCollection de tra ve du lieu de phan trang
        
        $arr['data'] = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();

        return $this->successResponse($arr);
        
    }

    public function generateSlug(generateSlugRequest $request):JsonResponse
    {
        try{
            $title = $request->get('title');
            $slug = SlugService::createSlug(Post::class,'slug',$title);
            //tu dong tao slug 

            return $this->successResponse($slug);
            //tra ve slug ve file create.blade.php
        } catch(\Throwable $e){
            return $this->errorResponse($e);
        }
    }

    public function checkSlug(checkSlugRequest $request):JsonResponse
    {
        return $this->successResponse();
    }
}

