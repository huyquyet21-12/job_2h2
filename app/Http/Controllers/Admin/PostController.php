<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ObjectLanguage as EnumsObjectLanguage;
use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostLevelEnum;
use App\Enums\PostRemotableEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Controllers\SystemConfigController;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Language;
use App\Models\ObjectLanguage;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostController extends Controller
{
    use ResponseTrait;
    //ke thua ResponseTrait
    
    private string $table;
    private object $model;
    // use SystemConfigController;

    public function __construct()
    {
        $this->model = Post::query();
        $this->table = ( new Post() )->getTable();

        View::share('title',ucwords($this->table));
        View::share('table',$this->table);
    }

    public function index()
    {
        $levels = PostLevelEnum::asArray();
        return view('admin.posts.index',[
            'levels' => $levels,
        ]);
    }

    public function create()
    {
        // $companies = Company::query()->get();
        $configs = SystemConfigController::getAndCache();
        $remotables = PostRemotableEnum::getArrWithoutAll();
        

        return view('admin.posts.create',[
            'currencies' => $configs['currencies'],
            'countries' => $configs['countries'],
            'remotables' => $remotables,
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $arr = $request->only([
                'job_title',
                'district',
                'city',
                'min_salary',
                'max_salary',
                'currency_salary',
                'requirement',
                'start_date',
                'end_date',
                'number_applicants',
                'slug',
            ]);

            $companyName = $request->get('company');
            
            if(!empty($companyName)) {
                $arr['company_id'] = Company::firstOrCreate(['name' => $companyName])->id;
            }
            if($request->has('remotable')){
                $arr['remotable'] = $request->get('remotable');
            }
            if($request->has('can_parttime')) {
                $arr['can_parttime'] = 1;
            }
            $languages = $request->get('languages');
            
            $post = Post::create($arr);

            foreach($languages as $language){
                $language = Language::firstOrCreate(['name' => $language]);
                //kiem tra xem language co ton tai hay chua
                ObjectLanguage::create([
                    'object_id' => $post->id,
                    'language_id' => $language->id,
                    'object_type' => Post::class,
                ]);
            }
            DB::commit();
            //neu thanh cong => se commit
            
            return $this->successResponse();
        } catch(\Throwable $e) {
            DB::rollBack();
            //neu khong thanh cong => se khong day len
            return $this->errorResponse();
        }
    }

    public function importCsv(Request $request):JsonResponse
    {
        try {
            $file = $request->file('file');
            $levels = $request->input('levels');
            Excel::import(new PostImport($levels), $file);
            
            return $this->successResponse();
        } catch(\Throwable $e) {
            return $this->errorResponse($e);
        }
    }
}
