<?php

namespace App\Models\Admodels;
use Illuminate\Database\Eloquent\Model;
use DB;


use App\Traits\PGSMetable;
use App\Traits\DataTrait;
use App\Traits\PGSMediaTrait;
use Nestable\NestableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Description of FileUploadModel
 *
 * @author The Oracle
 */
 use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
 
class PostMediaModel extends Model implements AuditableContract{
    
	use \OwenIt\Auditing\Auditable;
	
		   
        use PGSMetable,DataTrait,PGSMediaTrait, SoftDeletes;
		
    protected $table = 'post_media';
	
    protected $primaryKey = 'pm_id';
	
	protected $with = ['fileOwner'];

    protected $fillable = array(
                                "pm_id",
                                "pm_post_id",
                                "pm_lang",
                                "pm_media_type",
								"pm_cat",
								"pm_title",
								"pm_title_arabic",
								"pm_source",
								"pm_source_arabic",
								"pm_name",
								"pm_orig_name",
								"pm_file_hash",
								"pm_owner_id",
								"pm_uploaded_on",
								"pm_file_type",
								"pm_extension",
								"pm_size",
								"pm_status",
								"pm_priority"
                            );
    const CREATED_AT = 'pm_created_at'; 

    const UPDATED_AT = 'pm_update_at';
    
    
	
	public function scopeActive($query){
        return $query->where('pm_status', 1);
    }

    public function scopeInActive($query){
        return $query->where('pm_status', 2);
    }
	
	public function scopeDeleted($query){
        return $query->where('pm_status', 3);
    }
	
	public function fileOwner(){
		return $this->hasOne('App\User','id','pm_owner_id');
	}
}