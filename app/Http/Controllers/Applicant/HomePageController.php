<?php
namespace App\Http\Controllers\Applicant;

use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\HomePage\IndexRequest;
use App\Models\Config;
use App\Models\Post;
use Illuminate\Http\Request;

class HomePageController extends Controller 
{
    public function index(IndexRequest $request)
    {
        $searchCities = $request->get('cities',[]);
        $congigs = Config::getAndCache(false);
        //false === 0
        $minSalary = $request->get('min_salary',$congigs['filter_min_salary']);
        $maxSalary = $request->get('max_salary',$congigs['filter_max_salary']);
        //neu khong co => mac dinh se bang trong cache configs
        $remotable = $request->get('remotable');
        // dd($arrCity);
        $searchCanPartTime = $request->boolean('can_parttime');
        

        $filters = [];
        if(!empty($searchCities)){
            $filters['cities'] = $searchCities;
        }
        if($request->has('min_salary')){
            $filters['min_salary'] = $minSalary;
        }
        if($request->has('max_salary')){
            $filters['max_salary'] = $maxSalary;
        }
        if(!empty($remotable)){
            $filters['remotable'] = $remotable;
        }
        if(!empty($searchCanPartTime)){
            $filters['can_parttime'] = $searchCanPartTime;
        }
        
        $posts = Post::query()
        ->IndexHomePage($filters)
        ->paginate();
        $arrCity = getAndCachePostCities();
        $filterPostRemotable = PostRemotableEnum::getArrWithLowerKey();

        return view('applicant.index',[
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
            'min_salary' => $minSalary,
            'max_salary' => $maxSalary,
            'configs' => $congigs,
            'filterPostRemotable' => $filterPostRemotable,
            'remotable' => $remotable,
            'searchCanPartTime' => $searchCanPartTime,
            
        ]);
    }

    public function show($postID)
    {
        $post = Post::query()
        ->with('file')
        ->approved()
        ->find($postID);

        $title = $post->job_title;

        return view('applicant.show',[
            'post' => $post,
            'title' => $title,
        ]);
    }
}