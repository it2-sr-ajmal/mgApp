<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use Illuminate\Support\Facades\Redirect;
use App\User as User;
use Auth;
use Config;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use URL;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class UsersController extends AdminBaseController {
	
	protected $roleNames;
	protected $rolesObj;
	public function __construct(Request $request){
		parent::__construct($request);
		$this->roleNames = ['Super Admin','User Manager'];
	}

	 /**
	* user list 
	* @param Request $request
	* @return View
	*/

	public function index(Request $request){
		
		
		
		if($request->route()->getName() == 'admin_users'){
			if( !$this->userObj->hasAnyPermission('Manage Admin Users List') ){
				return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
			}
			
			$query =  User::where('is_admin',1);
			$view = 'admin.users.admin_users_list';
		}else{
			
			if( !$this->userObj->hasAnyPermission('Manage Users') ){
				return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
			}
			
			$query =  User::where('is_admin',2);
			$view = 'admin.users.list';
		}
		//$this->data['users'] = User::paginate(50)->appends(Input::except('page'));

		$name = $request->input('name');
		$query->when($name, function ($q) use ($name) {
			return $q->where('user_full_name','LIKE', "%$name%");
		});
		$email = $request->input('email');
		$query->when($email, function ($q) use ($email) {
			return $q->where('user_email','LIKE', "%$email%");
		});
		$status = $request->input('status');
		$query->when($status, function ($q) use ($status) {
			return $q->where('user_status', $status);
		});
	
		$this->data['users'] = $query->orderby('created_at','DESC')->paginate(50)->appends($request->except('page'));
		$this->data['countryList'] = CountryModel::where('country_status','=',1)->get();
		return view($view,$this->data);
	}
    
    private function _getYearMonths($format='F'){
      $res = [];
      for($m=1; $m<=12; ++$m){
            $res[] = date($format, mktime(0, 0, 0, $m, 1));
      }  
      return $res;
    }
    
    /**
	* user dashboard 
	* @param Request $request
	* @return View
	*/
    
	public function dashboard(Request $request){
                
		$this->data['isDashBoard'] = true;
		$this->data['pageTitle'] = "Dashboard";
		return view('admin.dashboard.dashboard',$this->data);
	}
	

	public function create(Request $request){
		
        if( !$this->userObj->hasAnyPermission('Create Users') ){
			return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
		}
		if($request->input('createbtnsubmit')){
		// pre($request->all());
		$inputs = [
			'user_full_name' => $request->input('user_full_name'),
			'user_email' => $request->input('user_email'),
			'password' => $request->input('password'),
			'user_phone_number' => $request->input('user_phone_number'),
			'user_status' => $request->input('user_status'),
			
		];
		$rules = [
			'user_full_name' => 'required',
			'user_email' => 'required|email|unique:users',
			//'password' => 'required',
			'user_phone_number' => 'required',
			'user_status' => 'required',
		];
		

		$messages = [
			'user_full_name.required' => 'Name is required',
			'user_email.required' => 'Email is required',
			'user_email.email' => 'Invalid Email',
			'password.required' => 'Password is required',
			'password.regex' => 'Your password should be minimum eight characters, at least one letter and one number',
			'user_phone_number.required' => 'Phone number is required',
			'user_status.required' => 'Status is required',
			
		];
		$rules['password'] = ['required','regex:/^(?=.*[A-Za-z])(?=.*\d).{8,}$/'];
		$validator = Validator::make($inputs,$rules,$messages);
			if($validator->fails()){
				$request->flash();
				$messages = $validator->messages();
				$userMessages =$this->custom_message('Fields are mandatory!','error');
				$userMessages.='<ul class="validation_errors">';
				foreach ($messages->all('<li>:message</li>') as $message){
					$userMessages .= $message;
				}

				$userMessages.='</ul></div>';
				return Redirect(apa('admin_users/create'))->with('userMessage',$userMessages);
			}else{
				try{
				$db_inputs = [
					'user_full_name' => $request->input('user_full_name'),
					'user_email' => $request->input('user_email'),
					'password' => $request->input('password'),
					'user_phone_number' => $request->input('user_phone_number'),
					'user_status' => $request->input('user_status'),
					
				];
				$db_inputs['password'] = \Hash::make($inputs['password']);
				
				$db_inputs['is_admin'] = 1;

				if($request->file('user_avatar')){
					$uploadPath = 'public/user/';
					$dimension = array(array('folder'=>'','width'=>'400','height'=>'400'));
					$fileName = $this->resize_and_crop_image('user_avatar',$uploadPath ,$dimension,null);
					$arr['user_avatar'] = $fileName;
				}

				$user = User::create($db_inputs); //Retrieving only the email and password data
				//$this->_updateHubAllotment($request,$user->id);
				$roles = $request['roles']; //Retri
				if (isset($roles)) {
					foreach ($roles as $role) {
						$role_r = Role::where('id', '=', $role)->firstOrFail();  
						$user->assignRole($role_r); //Assigning role to user
					}

       			}
   
				/* $memberRole = Role::where('name','=','Website Member')->first();
				$user->assignRole($memberRole); */
				$userMessages ='<div class="alert alert-success">User Account created</div>';
				}catch( \Illuminate\Database\QueryException $e ){
					\Input::flash();
					$errorInfo = $e->errorInfo;
                    if($errorInfo[0] == 23000){
                        $userMessages ='<div class="alert alert-danger">User Account already exist.'.$e->getMessage().'</div>';
                    }

				}
	
				return redirect(apa('admin_users/create'))->with('userMessage',$userMessages);
			}

		}

		$this->data['roles'] = Role::get();
		$this->data['countryList'] = CountryModel::where('country_status','=',1)->get();
        return view('admin.users.add',$this->data);
	}

	public function update($editID, Request $request){
		/* if(!$this->checkPermission('Edit User')){
			return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
		}
 */
		/* if (!Auth::user()->hasPermissionTo('Edit User')) {
           return redirect()->to(adminPrefix().'/dashboard')->with('errorMessage','Invalid Request');
        }
 */			

		$userOrRegistrations = 'users';
		$view = 'admin.users.edit';
		if($request->route()->getName() == 'admin_user_edit'){
			$userOrRegistrations =  'admin_users';
			$view = 'admin.users.admin_user_edit';
		}
		
		
		
		if(empty($editID)) { return redirect()->to(apa($userOrRegistrations));}

		$user = User::findOrFail($editID);
		if(empty($user)){
			return redirect()->to(apa($userOrRegistrations));
		}

		/**/ if( $user->hasRole('Super Admin') && !Auth::user()->hasRole('Super Admin') ) { 
			return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission');
		}
 
		$this->data['messages']='';
		if($request->input('updatebtnsubmit')){
		$inputs = [
			'user_full_name' => $request->input('name'),
			'user_phone_number' => $request->input('user_phone_number'),
			'user_status' => $request->input('status'),
		];
		$rules = [
			'user_full_name' => 'required',
			'user_phone_number' => 'required',
			'user_status' => 'required',
		];
		

		$messages = [
			'user_full_name.required' => 'Name is required',
			'user_phone_number.required' => 'Phone number is required',
			'user_status.required' => 'Status is required',
			];
			
		$validator = Validator::make($inputs, $rules, $messages);
			if($validator->fails()){
				$request->flash();
				$messages = $validator->messages();
				$userMessages ='<div class="alert alert-danger"><ul class="validation_errors">';
				foreach ($messages->all('<li>:message</li>') as $message){
					$userMessages .= $message;
				}

				$userMessages.='</ul></div>';
				return Redirect(apa($userOrRegistrations.'/update/'.$editID))->with('userMessage',$userMessages);
			}else{
				

				if($request->file('user_avatar')){
					$uploadPath = 'public/user/';
					$dimension = array(array('folder'=>'','width'=>'400','height'=>'400'));
					$fileName = $this->resize_and_crop_image('user_avatar',$uploadPath ,$dimension,null);
					$arr['user_avatar'] = $fileName;
				}
                if($request->input('password')){
					$inputs['password'] = \Hash::make($request->input('password'));
				}
				
				
				$user->fill($inputs)->save();
				$roles = $request->input('roles');
				$user->roles()->sync($roles);
				$userMessages = '<div class="alert alert-success">User Details updated successfully</div>';
				return Redirect(apa($userOrRegistrations.'/update/'.$editID))->with('userMessage',$userMessages);
			}

		}

		$this->data['user'] = DB::table('users')->where('id','=',$editID)->get();
		$this->data['roles'] = Role::get(); //Get all roles
		$userRoleIDs = array('-1');
		//pre($user);
		foreach($user->roles as $role){
			$userRoleIDs[] = $role->id;
		}

		$this->data['userRoleIDs'] = $userRoleIDs;
		$this->data['user'] = User::findOrFail($editID);
		$this->data['countryList'] = CountryModel::where('country_status','=',1)->get();
		return view($view,$this->data);
	}

	
	private function _isRoleSelected($roleName = '',$request){
		if(empty($request->input('roles'))){
			return false;
		}

		$roleIndex = str_replace(' ','_',$roleName);
		if(!$this->rolesObj || !isset($this->rolesObj[$roleIndex])){
			$this->rolesObj[$roleIndex] = Role::select('id')->where('name','=',$roleName)->first();
		}

		return (in_array($this->rolesObj[$roleIndex]->id,$request->input('roles')));
	}

	public function admin_errorpage(){
		return view('admin.error.errorpage',$this->data);
	}

	public function changestatus(Request $request,$statusID){
	
	/* 
		if(!$this->checkPermission('Edit User')){
				return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
		}
		if (!Auth::user()->hasPermissionTo('Edit User')) {
			return redirect()->to(adminPrefix().'/dashboard')->with('errorMessage','Invalid Request');
		}
	*/
		$userOrRegistrations = 'users';
		if($request->route()->getName() == 'admin_user_change_status'){
			$userOrRegistrations =  'admin_users';
		}
		$user = User::find($statusID);
		$currentStatus = $user->user_status;
		$currentStatus = ($currentStatus==2)?1:2;
		$currentStatusdatas = array("user_status"=>$currentStatus);
		DB::table('users')->where('id', '=',$statusID)->update($currentStatusdatas);
		return redirect()->to(apa($userOrRegistrations))->with('userMessage','Status Changed');
	}

	public function delete($deleteID){
		/* if(!$this->checkPermission('Delete User')){
			return Redirect(route('admin_dashboard'))->with('userMessage','Invalid Permission') ;
		}
 */
        /* if (!Auth::user()->hasPermissionTo('Delete User')) {
           return redirect()->to(adminPrefix().'/dashboard')->with('errorMessage','Invalid request. Insufficient privileges');
        }
 */
		if(empty($deleteID)) { return redirect()->to(apa('users'));}

		$user = User::find($deleteID);
		if($user->id!=1){
			$user->delete();
		}
		
		return redirect()->to(apa('users'))->with('userMessage','User account deleted');
	}
	 
	 
	 
public function getUserDetails(Request $request){
	
	if($request->ajax()){
		
		if(empty($request->input('id'))){
			return \Response::json(array('status'=>false,'data'=>null,'message'=>'No user details found!'));
		}
		
		$id = $request->input('id');
		
		if($request->route()->getName() == 'registration_details'){
			
			$details = User::filter($request)->where('id',$id)->first();
			// pre($details->toArray());
			$this->data['details'] = $details;
			
			$dom = View('admin.registrations.user_details',$this->data)->render();
			
			return \Response::json(array('status'=>true,'dom'=>$dom,'message'=>'User Found.'));
		}
		
		
	}
	
	
	}
	
	
	public function resendEmailVerification($userId, Request $request)
	{
		
            
            $redirectRoute = $request->input('redirectUrl');
            
            $user=User::find($userId);
            
            // pre($user);
            
            $regAuthCode = \Hash::make($user->user_email. microtime());
            $confirmationLink = URL::to('/confirm-email?code=' . $regAuthCode);
            
            // pre(Auth::user()->id);
            
            $data = ['user_validate_code'=>$regAuthCode];
            User::where('id','=',$userId)->update($data);
            
            $loginLink = '';

            $mailData = array(
                'user_name' => $user->user_full_name,
                'user_phone_code' => $user->user_phone_code,
                'user_phone_number' => $user->user_phone_number,
                'user_email' => $user->user_email,
                'confirmationLink' => $confirmationLink,
            );
            
            // pre($user->user_email);
            
            $template = 'frontend.emailTemplate.resendEmailVerificationLink'; 
            $toEmails = $user->user_email;
            if (!empty($toEmails)) {
                $settings=[
                    'to'=> $toEmails,
                    'subject'=> 'Verify your email'
                ];
                $job = new SendEmail($settings,$mailData,$template);
                dispatch($job); 
            }
			$userMessages ='<div class="alert alert-success">Email send Successfully</div>';
            return redirect()->back()->with('userMessage',$userMessages);
	}
	public function verifyUser($userId)
	{
		
		$user = User::find($userId);
		$user->user_email_confirmed=1;
		$user->save();
		$userMessages ='<div class="alert alert-success">Email verified successfully</div>';
        return redirect()->back()->with('userMessage',$userMessages);
		
	}
}