<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\ActivityLogs;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
                $username = $data['username'];
                $password = $data['password'];
                $verifyHomisAccountIfExist = DB::select("
                                    Select top 1 * from hospital.dbo.user_acc
                                    where  user_name = '$username'   
                                    and user_pass = webapp.dbo.ufn_crypto('$password',1)                                 
                                    ");   

                $homisPassword = "";
                $employeeId = "";

                if (count ($verifyHomisAccountIfExist) == 1) {                    
                $homisPassword = $password;                      
                $employeeId = $verifyHomisAccountIfExist[0]->employeeid;  
                    
                }
              
                $verifyLinenAccountIfExist = DB::select("
                    select username from nora.paul.linen_users where username = '$username'                             
                    "); 
                if(count ($verifyLinenAccountIfExist) == 1) {
                  $verifyUsername=$verifyLinenAccountIfExist[0]->username;
                } else {
                    $verifyUsername ="";
                }
               
                
               
                return Validator::make($data, [
                    'username' => ['required', 'string', 'max:255','not_in:'.$verifyUsername], 
                    'password' => ['required', 'string', 'confirmed','in:' . $homisPassword],
                    
                ]);
        

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $verifyHomisAccountIfExist = DB::select("
                            Select top 1 * from hospital.dbo.user_acc
                            where  user_name = '$username'   
                            and user_pass = webapp.dbo.ufn_crypto('$password',1)                                 
                            ");   
        $employeeId = $verifyHomisAccountIfExist[0]->employeeid;    
       
        $userDetails = DB::select("Select top 1 * from hpersonal where employeeid = '$employeeId'");
        $userFullname = $userDetails[0]->lastname.", ".$userDetails[0]->firstname." ".$userDetails[0]->middlename;

        if (Arr::exists($data, 'ward')) {            
           $ward = $data['ward'];
        } else {
            $ward = null;
        }

        if (Arr::exists($data, 'office')) {
           $office = $data['office'];
        } else {
            $office = null;
        }

        ActivityLogs::create(['activity_details' => 'Added new user: '.$employeeId]);

        return User::create([
            'username' => $data['username'],   
            'name'     => $userFullname,
            'password' => Hash::make($data['password']),
            'employee_id' => $employeeId,
            'ward_id' => $ward,
            'office_id' => $office,
            'role_id' => 3,
            'role_name' => 'user'
        ]);
    }
}
