<?php
namespace App\Models\Admodels;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Extension\BaseAppModel;
use Cviebrock\EloquentSluggable\Sluggable;
use \Venturecraft\Revisionable\RevisionableTrait;
use Cviebrock\EloquentTaggable\Taggable;
use Plank\Metable\Metable;
use App\Traits\PGSMetable;
use App\Traits\DataTrait;
use App\Traits\PGSMediaTrait;
//use Nestable\NestableTrait;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App;


use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class PostModel extends Model implements AuditableContract {
		
		use Sluggable, \OwenIt\Auditing\Auditable;
		//use RevisionableTrait;
		//use NestableTrait;
        use Taggable;        
        use PGSMetable,DataTrait,PGSMediaTrait , SoftDeletes;
		
		/**
		 * The database table used by the model.
		 *
		 * @var string
		 */
		// protected $parent = 'post_category_id';
        
        
		protected $table = 'posts';

        protected $primaryKey = 'post_id';
        
        protected $with = ['meta','parentPost','media'];
        
        protected $revisionEnabled = true;
        protected $revisionCreationsEnabled = true;
        protected $historyLimit = 50;
       // protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
      

		protected $fillable =  [ 
                                    'post_slug',
                                    'post_type',
                                    'post_parent_id',
                                    'post_category_id',
                                    'post_sub_category_id',
                                    'post_title',
                                    'post_title_arabic',
                                    'post_image',
                                    'post_image_arabic',
                                    'post_priority',
                                    'post_set_as_banner',
                                    'post_created_by',
                                    'post_updated_by',                                    
                                    'post_status',
                                    'deleted_at'
                                ];

        const CREATED_AT = 'post_created_at';

        const UPDATED_AT = 'post_updated_at';
        
        public function sluggable(){
            return [
                'post_slug' => [
                    'source' => 'removeTags'
					]
            ];
        }
		
		
		public function scopeActive($query){
			return $query->where('post_status', 1);
		}

		public function scopeInActive($query){
			return $query->where('post_status', 2);
		}
	
	
		public function getRemoveTagsAttribute() {
			return strip_tags($this->post_title);
		}
		
        public static function boot(){
            parent::boot();
        }
		
		function isActive(){
			return ($this->post_status == 1);
		}
		
		public function postTags(){
			return $this->hasOne('\App\Models\Admodels\PostTagModel','taggable_id','post_id');
		}
		
        public function parentPost(){
			return $this->hasOne('\App\Models\Admodels\PostModel','post_id','post_parent_id');
		}
        
		public function bannerPost(){
			return $this->hasOne('\App\Models\Admodels\PostModel','post_id','post_parent_id');
		}
		
		public function category(){
			return $this->belongsTo('\App\Models\CategoryModel','post_category_id','category_id')->orderBy('category_priority','ASC');
		}
		
		public function subCategory(){
			//return $this->belongsTo('\App\Models\CategoryModel','post_sub_category_id','category_id')->orderBy('category_priority','ASC');
			return $this->hasOne('\App\Models\CategoryModel','category_id','post_sub_category_id')->orderBy('category_priority','ASC');
		}
		
        public function childPosts(){
			return $this->hasMany('\App\Models\Admodels\ChildPostModel','post_parent_id','post_id')->whereNull('deleted_at');
		}
        
		
        public function imageGallery(){
		}
        public function videoGallery(){
			$lang=(App::getLocale()=="en")?'ar':'en';
			
			$tmp = $this->hasMany('\App\Models\Admodels\PostMediaModel','pm_post_id','post_id')
			->whereNotNull('pm_post_id')	
			->where('pm_cat','=','video');
			if(!empty(\Auth::user()) && \Auth::user()->isAdmin()){			
			}else{
				$tmp = $tmp->where(function($q) use($lang){
					$q->where('pm_lang','!=',$lang);
					$q->orWhereNull('pm_lang');
				});
			}
			
						
			return  $tmp ->where('pm_status','=',1)	
			->orderBy('pm_priority','ASC');
		}
		
        public function media(){
			
			$lang=(App::getLocale()=="en")?'ar':'en';
			
			$tmp = $this->hasMany('\App\Models\Admodels\PostMediaModel','pm_post_id','post_id')->whereIn('pm_cat',['gallery_file','video']);
			
			if(!empty(\Auth::user()) && \Auth::user()->isAdmin()){			
			}else{
				$tmp = $tmp->where(function($q) use($lang){
					$q->where('pm_lang','!=',$lang);
					$q->orWhereNull('pm_lang');
				});
			}
			return  $tmp->where('pm_status','=',1)			
					->orderBy('pm_priority','ASC');
		}

        function getTitle(){
			return $this->getData('post_title');
		}

        function getId(){
			return $this->post_id;
		}




}