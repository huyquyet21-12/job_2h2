<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $company_id
 * @property string $job_title
 * @property string|null $district
 * @property string|null $city
 * @property int|null $remotable
 * @property int|null $can_parttime
 * @property float|null $min_salary
 * @property float|null $max_salary
 * @property int $currency_salary
 * @property string|null $requirement
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $number_applicants
 * @property int $status
 * @property int $is_pinned
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\File|null $file
 * @property-read mixed $currency_salary_code
 * @property-read string|null $location
 * @property-read mixed $remotable_name
 * @property-read string|null $salary
 * @property-read mixed $status_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post approved()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCanParttime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCurrencySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMaxSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMinSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereNumberApplicants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRemotable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRequirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'company_id',
        'job_title',
        'levels',
        'status',
        'district',
        'city',
        'remotable',
        'can_parttime',
        'min_salary',
        'max_salary',
        'currency_salary',
        'requirement',
        'start_date',
        'end_date',
        'number_applicants',
        'is_pinned',
        'slug',
        
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // protected $appends = ['currency_salary_code'];
    //them khi load trang se kem theo gia tri cua currency_salary

    protected static function booted()
    {
        static::creating(function ($object) {
            $object->user_id = user()->id;
            $object->status = PostStatusEnum::getByRole();
        });

        static::saved(static function ($object){
            //Moi lan luu 1 bai dang moi
            $city = $object->city;
            //Lay city tu bai dang day =>
            $arr = explode(', ',$city);
            //cat chuoi
            $arrCity = getAndCachePostCities();
            //lay danh sach city cu trong cache neu co
            foreach($arr as $item){
                if(in_array($item,$arrCity)){
                    continue;
                }
                $arrCity[] = $item;
                //cap nhat city moi
            }
            cache()->put(SystemCacheKeyEnum::POST_CITIES,$arrCity);
            //luu lai
            //khi them cai gi do => tu dong luu lai
            //Khi cap nhap saved => luu lai xong model thanh cong
            //=> truyen city moi vao arrCity trong cache
        });
        //khi dang tao => them vao
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }

    

    public function languages():MorphToMany
    {
        //polymorphucRelationships
        return $this->morphToMany(
            Language::class,
            'object',
            //ten no la object => truy van den bang language
            ObjectLanguage::class,
            'object_id',
            'language_id',
        );
    }

    public function company(): BelongsTo
    {
        //moi bai dang chi co 1 cong ty
        //=> belongsTo
        return $this->belongsTo(Company::class);
    }

    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }

    public function getCurrencySalaryCodeAttribute()
    {
        //khi can lay ra chi can goi 'currency_salary_code'
        //lay ra gia tri cua currency_salary
        return PostCurrencySalaryEnum::getKeys($this->currency_salary)[0];
    }

    public function getRemotableNameAttribute()
    {
        
        // dd(PostRemotableEnum::getKey(PostRemotableEnum::REMOTE_ONLY));
        // dd($this->remotable);
        return  PostRemotableEnum::getKeys($this->remotable)[0];
        
    }

    public function getStatusNameAttribute()
    {
        return PostStatusEnum::getKeys($this->status)[0];
    }

    public function getLocationAttribute(): ?string
    {
        if(!empty($this->district)){
            //neu khong trong district
            return $this->district . ' - ' . $this->city;
        }
        return $this->city;
    }

    public function getSalaryAttribute(): ?string 
    {
        $val = $this->currency_salary;
        $key = PostCurrencySalaryEnum::getKey($val);
        $locale = PostCurrencySalaryEnum::getLocaleByVal($val);
        $format = new \NumberFormatter($locale,\NumberFormatter::CURRENCY);
        $rate = Config::getByKey($key);

        if(!is_null($this->min_salary)){
            $salary = $this->min_salary * $rate;
            $minSalary = $format->formatCurrency($salary,$key);
        }

        if(!is_null($this->max_salary)){
            $salary = $this->max_salary * $rate;
            $maxSalary = $format->formatCurrency($salary,$key);
        }

        if(!empty($minSalary) && !empty($maxSalary)){
            return $minSalary . ' - ' . $maxSalary;
        }

        if(!empty($minSalary)){
            return __('frontpage.from_salary') . ' ' . $minSalary;
        }

        if(!empty($maxSalary)){
            return __('frontpage.to_salary') . ' ' . $maxSalary;
        }

        return '';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', PostStatusEnum::ADMIN_APPROVED);
    }

    public function getIsNotAvailableAttribute(): bool
    {
        if (empty($this->start_date)) {
            return false;
        }
        if (empty($this->end_date)) {
            return false;
        }

        return !now()->between($this->start_date, $this->end_date);
    }

    
    public function scopeIndexHomePage($query, $filters)
    {
        return $query
            ->with([
                'languages',
                'company' => function ($q) {
                    $q->select([
                        'id',
                        'name',
                        'logo',
                    ]);
                }
            ])
            ->approved()
            ->when(isset($filters['cities']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    foreach ($filters['cities'] as $searchCity) {
                        $q->orWhere('city', 'like', '%' . $searchCity . '%');
                    }
                    $q->orWhereNull('city');
                });
            })
            ->when(isset($filters['min_salary']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('min_salary', '>=', $filters['min_salary']);
                    $q->orWhereNull('min_salary');
                });
            })
            ->when(isset($filters['max_salary']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('max_salary', '>=', $filters['max_salary']);
                    $q->orWhereNull('max_salary');
                });
            })
            ->when(isset($filters['remotable']), function ($q) use ($filters) {
                $q->where('remotable', $filters['remotable']);
            })
            ->when(isset($filters['can_parttime']), function ($q) use ($filters) {
                $q->where('can_parttime', $filters['can_parttime']);
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('id');
    }
}
