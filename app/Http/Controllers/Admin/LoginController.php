<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\User as User;
use Auth;
use Input;
use Config;
use Illuminate\Http\Request;

class LoginController extends AdminBaseController {
	
    public function __construct(Request $request){

		 parent::__construct($request);
	}

	public function index(Request $request){
		
		if(Auth::user() ) return redirect()->to(Config::get('app.admin_prefix').'/dashboard');
		$this->data['message']='';
		
		if($request->input('user_email')){
			
			$inputs = [
				'email'=>$request->input('user_email'),
				'password'=>$request->input('password'),
				// 'captcha'=>$request->input('g-recaptcha-response'),
			];
			$rules = [
				'email' => 'required',
				'password' => 'required',
				// 'captcha' => 'required|recaptcha',
			];
			
			$messages = [
				'email.required' => 'Email is required',
				'password.required' => 'Password is required',
				'captcha.required' => 'Captcha is required',
				// 'captcha.recaptcha' => 'Invalid captcha',
			];
			
			$validator = \Validator::make($inputs,$rules,$messages);
			if($validator->fails()){
				
                $request->flash();
				$errors = '<ul class="alert alert-danger">';
				$messages = $validator->messages()->all();
				foreach($messages as $message){
					$errors .= '<li>'.$message.'</li>';
				}
				$errors .= '</ul>';
				return redirect()->to(Config::get('app.admin_prefix'))->with('userMessage',$errors);
			}else{
			
				// $credentials = array('email' => $request->input('user_email'), 'password' => $request->input('password'),'is_admin'=>1,'status'=>1);
				$credentials = array('user_email' => $request->input('user_email'), 'password' => $request->input('password'),'user_status'=>1);

				if(Auth::attempt($credentials)){
                     User::where('id','=',Auth::user()->id)
                     ->update(['last_logged_in'=>\Carbon\Carbon::now()->toDateTimeString()]); 
					 // pre(Auth::user());
					 return redirect()->to(Config::get('app.admin_prefix').'/dashboard');
				}else{
					$this->data['userMessage']= $this->custom_message("Invalid Username & Password",'error');
				}
				
			}
		}
		
		$this->data['pageTitle'] .="Login";
		// $this->data['isAdminLogin'] = ( Auth::user() && Auth::user()->is_super_admin == 1) ?true:false;
		// pre($this->data['isAdminLogin']);
		return view('admin.users.login',$this->data);
		
	}
	
	public function logout(){
	 	Auth::logout();
		\Session::flush();
		return redirect()->to(Config::get('app.admin_prefix').'');
	}

	public function create_admin_account(){
		//if admin account exist then redirect to login
		if(!User::admin_exist()){
			return redirect()->to(Config::get('app.admin_prefix').'/');
		}
		// die('asd');
		$this->data['pageTitle'] = 'Create Admin Account';
		if(\Request::isMethod('post')){
			$validation = \Validator::make(
				array(
					'name' => $request->input( 'fname' ),
					'email' => $request->input( 'aemail' ),
					'username' => $request->input( 'aemail' ),
					'password' => $request->input( 'apass' ),
					'password_confirmation' => $request->input( 'acpass' ),
				),
				array(
					 'name' => array( 'required' ),
					'email' => array( 'required', 'email' ),
					 'username' => array( 'required' ),
					'password' => array( 'required', 'confirmed' ),
					'password_confirmation' => array( 'required' ),
				)
			);

			if( !$validation->fails() ){
				// $password = $this->get_password_hash($request->input( 'password' ));
				$password = \Hash::make($request->input( 'acpass' ));
				$user = new User;
				$user->name = $request->input('fname').$request->input('lname');
				$user->username = $request->input('aemail');
				$user->email = $request->input('aemail');
				$user->password = $password;
				$user->is_admin = 1;
				$user->status = 1;
				$user->save();
				return redirect()->to(Config::get('app.admin_prefix').'/')->with('userMessage','Admin account created. Please login with your credentials.');
			}else{
				Input::flash();
				$this->data['message'] = $validation->messages();
			}
		}

		return view('admin.users.create',$this->data);
	}
}
