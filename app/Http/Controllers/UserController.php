<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\UserOTP;
use App\UniquePassword;
use App\Mail\SendOTPMessage;
use Session;
use App\Traits\UserLogTrait;

class UserController extends Controller
{
	use UserLogTrait;

	/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

	/**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
    	$user_details = getUserDetails();

        if ($user_details["user_level"] == 4){
	        $users = User::all();
	        $this->logActivity(" viewed the Employee List.");

	        return view('users.index')->with('user_details', $user_details)
	        							->with('users', $users);
        }else{
        	return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!')
        							  ->with('user_details', $user_details);
        }
    }

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$user_details = getUserDetails();

    	if ($user_details["user_level"] == 4){
	    	$this->logActivity(" is trying to create a new Employee.");
			return view('users.create')->with('user_details', $user_details);
		}else{
        	return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!');
        }
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate field
		$this->validate($request, [
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'birthdate' => 'required',
			'mobile_no' => 'required',
			'email' => 'required',
			'address' => 'required',
			'username' => 'required',
			'user_level' => 'required',
		]);

		$user = new User;
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->gender = $request->gender;
		$user->birthdate = $request->birthdate;
		$user->mobile_number = $request->mobile_no;
		$user->email = $request->email;
		$user->address = $request->address;
		$user->username = $request->username;
		$user->user_level = $request->user_level;
		$user->active = true;
		$user->save();

		if ($user){
			$this->logActivity(" has created a new Employee: User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('success', 'New Employee has been added!');
		}else{
			$this->logActivity(" has encountered a problem while creating a new Employee.");
			return redirect('/users/create')->with('error', 'Error saving New Employee to Database. Check your connection and Try again!');
		}

    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
    	$user_details = getUserDetails();

    	if ($user_details["user_level"] == 4){
	        $user = User::where('id', $user_id)
	        			->first();

	        $this->logActivity(" has viewed User Level " . $user->user_level . ": " . $user->full_name);

	        return view('users.profile')->with('user_details', $user_details)
	        							->with('user', $user);
        }else{
        	return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!');
        }
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $user_details = getUserDetails();

        if ($user_details["user_level"] == 4){
	        $user = User::where('id', $user_id)
	            ->first();

	        $this->logActivity(" is trying to update User Level " . $user->user_level . ": " . $user->full_name);

	        return view('users.edit')->with('user_details', $user_details)
	        						 ->with('user', $user);
        }else{
        	return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!');
        }
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $this->validate($request, [
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'birthdate' => 'required',
			'mobile_no' => 'required',
			'email' => 'required',
			'address' => 'required',
			'username' => 'required',
			'user_level' => 'required',
		]);

        $user = User::where('id', $user_id)
            ->first();

        $user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->gender = $request->gender;
		$user->birthdate = $request->birthdate;
		$user->mobile_number = $request->mobile_no;
		$user->email = $request->email;
		$user->address = $request->address;
		$user->username = $request->username;
		$user->user_level = $request->user_level;
		$user->save();

		if ($user){
			$this->logActivity(" has updated User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('success', 'Employee has been Updated!');
		}else{
			$this->logActivity(" has encountered a problem while updating User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users/'.$user_id .'/edit')->with('error', 'Error updating Employee. Check your connection and Try again!');
		}
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "We do not delete users, only deactivate them!";
    }

    //Custom User Methods

    public function activate($user_id){

    	$user = User::where('id', $user_id)
						->first();

		$user->active = true;
		$user->save();

		if ($user){
			$this->logActivity(" has activated User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('success', 'Employee has been Activated!');
		}else{
			$this->logActivity(" has encountered a problem while trying to activate User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('error', 'Error activating Employee. Check your connection and Try again!');
		}

    }

    public function deactivate($user_id){

    	$user = User::where('id', $user_id)
						->first();

		$user->active = false;
		$user->save();

		if ($user){
			$this->logActivity(" has deactivated User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('success', 'Employee has been Deactivated!');
		}else{
			$this->logActivity(" has encountered a problem while trying to deactivate User Level " . $user->user_level . ": " . $user->full_name);
			return redirect('/users')->with('error', 'Error deactivating Employee. Check your connection and Try again!');
		}
    }

	public function showLoginPage(){
		//redirect user to the login page
		return view('pages.login');
	}

	public function checkUsername(Request $request){

		//validate field
		$this->validate($request, [
			'username' => 'required'
		]);

		//get the username, check first if existing
		$username = $request['username'];

		$user = User::where('username', $username)
						->first();

		if (count($user) > 0){

			if ($user->active == true){

				$this->logActivity(" is trying to log in.", $user->id);

				$otp = $this->otpGenerator();
				$user_mobile_no = $user->mobile_number;

				//if yes, record the OTP
				$user_otp = new UserOTP;
				$user_otp->user_id = $user->id;
				$user_otp->password = $otp;
				$user_otp->used = false;
				$user_otp->save();

				//insert OTP into Unique Passwords
				$unique_password = UniquePassword::where('user_id', '=', $user->id)
							->first();

				if (count($unique_password) > 0){
					//update
					$unique_password->password = Hash::make($otp);
					$unique_password->save();
				}else{
					//create
					$new_unique = new UniquePassword;
					$new_unique->user_id = $user->id;
					$new_unique->password = Hash::make($otp);
					$new_unique->save();
				}

				//send the otp to user's mobile
              
				//send the otp to user's email

				if(!$user->email == ''){
					
					 Mail::to($user->email)->send(new SendOTPMessage($otp,$user));
				}
				
				//check if the otp was saved and proceed to password page
				if ($user_otp){

					return redirect('/password')->with('user_id', $user->id)->with('otp',$otp);
				}
			}else{

				$this->logActivity(" status is deactivated.", $user->id);
				return redirect('/login')->with('error', 'User has been deactivated. Contact your administrator.');
			}
		}else{
			//if not, return to login page and display error
			return redirect('/login')->with('error', 'User does not Exist!');
		}
	}

	public function showPasswordPage(){
		//redirect user to the login page
        return view('pages.password');
	}

    public function login(Request $request){
    	//get the username and password, check if the otp is correct
    	//validate field
		$this->validate($request, [
			'otp' => 'required'
		]);

		$user_id = $request['user_id'];
		$user_otp = $request['otp'];

		$otp = UserOTP::where([
						['user_id', '=', $user_id],
						['password', '=', $user_otp]
					])
					->first();

		if (count($otp) > 0){
			if ($otp->used == 0){
				
				if (Auth::attempt(['user_id' => $user_id, 'password' => $user_otp])){
					//update the otp field to 1
					$otp->used = true;
					$otp->save();

					//get user level
					$user_level = $this->getUserLevel($otp->user_id);

					$request->session()->put('user_id', $otp->user_id);
					$request->session()->put('user_level', $user_level);

					$this->logActivity(" is now logged in!");

					return redirect('/home');
				}else{

					$this->logActivity(" encountered a problem logging in.", $user_id);

					return redirect('/password')->with('error', 'Login Failed! Try Again!')->with('user_id', $user_id);
				}
			}else{
				$this->logActivity(" used an expired OTP.", $user_id);

				return redirect('/password')->with('error', 'OTP is expired!')->with('user_id', $user_id);
			}
		}else{

			$this->logActivity(" used the wrong OTP.", $user_id);

			return redirect('/password')->with('error', 'Username and OTP does not match!')->with('user_id', $user_id);
		}
    }

    public function logout(){

    	$this->logActivity(" has successfully logged out.");

    	Auth::logout();

    	Session::flush();

    	return redirect('/login')->with('success', 'You have successfully logged out!');
    }

    private function getUserLevel($user_id){
    	$user_level = User::where('id', $user_id)
    				->value('user_level');

    	return $user_level;
    }

    private function otpGenerator(){
		$otp = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)),0,6);
		return strtoupper($otp);
	}

	public function checkIfActive(Request $request){

		$user_id = $request->session()->get('user_id');

		$user = User::where('id', $user_id)
						->first();

		if ($user->active == false){

	    	$data = 'deactivated';
	    	return \Response::json($data);
	    }
	    else {
	    	$data = 'active';
    		return \Response::json($data);
	    }

	}

	public function logoutDeactivated(){

		$this->logActivity(" has been logged out.");

		Auth::logout();

		Session::flush();

		return redirect('/login')->with('error', 'Your account has been deactivated! Please contact your administrator.');
	}
}
