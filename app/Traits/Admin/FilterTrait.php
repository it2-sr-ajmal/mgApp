<?php
namespace App\Traits\Admin;
use App;
trait FilterTrait {
	
	public static function getFilterDom(){
		
		$filters = self::$filters;
		
		foreach($filters as $key => &$filter){
			if($filter['type'] == 'select'){
				$filter['data'] = [];
				$modelArr = $filter['model'];
				
				if(!empty($modelArr)){
					$modelName = $modelArr['src'];
					$modelTitleKey = $modelArr['title_key'];
					$dataModel = $modelName::all();
					$selectArr = [];
					if(!empty($dataModel)){
						foreach($dataModel as $d){
							$selectArr[$d->getKey()] = $d->{$modelTitleKey};
						}
						
					}
					$filter['data'] = $selectArr;
				}else{
					
					$filter['data'] = [
						1 => 'Active / Enabled',
						2 => 'Inactive / Disabled',
					];
				
				}
				
				
			}
		}

		$data['filters'] = $filters;
		return View('admin.common.filters',$data)->render();
		
	}
	
		
	function scopefilter($query,$request = null){
		
		$filters = self::$filters;
		$request = (empty($request)) ? request() : $request;
		foreach($request->all() as $key => $value){
			if(isset($filters[$key]) && !empty($value)){
				$realKey = str_replace('filter_','',$key);
				
				switch($filters[$key]['q']){
					case 'like':
						$query->where($realKey ,$filters[$key]['q'],'%'.$value.'%');
					break;
					
					case 'datetime':
						// $query->where($realKey ,$filters[$key]['q'],'%'.$value.'%');
					break;
					
					default :
						if($filters[$key]['model'] && $filters[$key]['model']['foreign']){
							$model = $filters[$key]['model']['src'];
							$modelData = $model::find($value);
							$query->whereHas($realKey,function($q) use($value,$modelData){
								$q->where($modelData->getKeyName(),'=',$value);
							});
						}else{
							$query->where($realKey ,'=',$value);
						}
					break;
				}
			}
		}
	}
	
}
?>