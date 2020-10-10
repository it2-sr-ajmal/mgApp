<?php
namespace App\Traits\Admin;
trait CustomMessageTrait {
	
	protected $inputs;
	protected $rules;
	protected $messages;
	protected $fillables;
	
	function createBootstrapAlert($message, $class='success'){
		return '<div class="alert alert-'.$class.'">'.$message.'</div>';
	}
}
?>
