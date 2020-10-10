<?php
namespace App\Models\Admodels;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Extension\BaseAppModel;
use Cviebrock\EloquentSluggable\Sluggable;

use Nestable\NestableTrait;
use App\Traits\DataTrait;
use App\Traits\CustomMenuTrait;

class MenuManagerModel extends Model {

		/**
		 * The database table used by the model.
		 *
		 * @var string
		 */
        use Sluggable,CustomMenuTrait;
        use NestableTrait,DataTrait;
        
        protected $parent = 'mm_parent_id';
        
		protected $table = 'menu_manager';
        
		protected  static $appLang;
        
        protected $primaryKey = 'mm_id';    

        

		protected $fillable =  [ 
                                    'mm_parent_id',
                                    'mm_title',
                                    'mm_title_arabic',
                                    'mm_icon_class',
                                    'mm_icon_file',
                                    'mm_large_title',
                                    'mm_large_title_arabic', 
                                    'mm_show_in_main_menu',
                                    'mm_show_in_footer_menu',
                                    'mm_show_in_mobile_menu',
                                    'mm_is_hash_link',
                                    'mm_is_hash_link_in_home_only',
                                    'mm_priority',
                                    'mm_status',
                                    'mm_created_by',
                                    'mm_updated_by',
                                ];

        const CREATED_AT = 'mm_created_at';

        const UPDATED_AT = 'mm_updated_at';
        
        public function sluggable(){
            return [
                'mm_slug' => [
                    'source' => 'mm_title'
                ]
            ];
        }
		
		public static function getFrontendMenuUL($request){

			self::$appLang = \App::getLocale();
			return self::firstulAttr('class', 'cd-primary-nav mainNavigation ')
						->ulAttr('class', 'dropdown-menu')
						->liAttr([
							'class'=>'',
							'id'=>'mm_id',
							'data-id'=>'mm_id',
						])
						->anchorAttr([
							'class'=>'',
							'data-href'=>'mm_slug',
							'data-slug'=>'mm_slug'
						])
						->active('menu-1')
						->orderBy('mm_priority','asc')
						->renderAsHtml();
		}
        
}