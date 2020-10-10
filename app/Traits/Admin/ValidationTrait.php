<?php
namespace App\Traits\Admin;
use Validator;
trait ValidationTrait {
	
	protected $inputs;
	protected $rules;
	protected $messages;
	protected $fillables;
	
	/**
	* @Param  Array
	**/
	
	function setFillables($itemsArr){
		if(!is_array($itemsArr)){
			die('Arguement passed to setFillables must be an array');
		}
		$this->fillables = $itemsArr;
	}
	
	/**
	* @Param Laravel Request, Array
	**/
	function validateInputs($request,$ignore = []){
		if(!is_array($ignore)){
			die('Second Arguement passed to validateInputs must be an array');
		}
		$this->_setInputs($request);
		$this->_setRules($ignore);
		$this->_setMessages($ignore);
		
		$validation = $this->validate($request,$this->rules,$this->messages);
		
		return $this->inputs;
	}
	
	/**
	* @Param Laravel Request
	**/
	private function _setInputs($request){
		foreach($request->all() as $key => $inputs){
			if(in_array($key,$this->fillables)){
				$this->inputs[$key] = $request->input($key);
			}
		}
	}
	
	/**
	* @Param Array
	**/
	private function _setRules($ignores){
		foreach($this->inputs as $key => $inputs){
			if(!in_array($key,$ignores)){
				$this->rules[$key] = 'required';
			}
		}
	}
	
	/**
	* 
	**/
	private function _setMessages(){
		foreach($this->rules as $key => $rule){
			$this->messages[$key.'.'.$rule] = 'This field is required';
			
		}
	}
	
}
?>
