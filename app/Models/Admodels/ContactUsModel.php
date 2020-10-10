<?php
    namespace App\Models\Admodels;

use Illuminate\Database\Eloquent\Model;

use DB;
use \App\Traits\DataTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUsModel extends Model {
	use DataTrait;
	use SoftDeletes;
		/**
		 * The database table used by the model.
		 *
		 * @var string
		 */

		protected $table = 'contact_us';

		protected $primaryKey = 'cu_id';

		protected $fillable = [
		'cu_name',
		'cu_email',
		'cu_enquire_about',
		'cu_message',
		'cu_phone_code',
		'cu_phone_number',
		'deleted_at'
		];
		
}