<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\InventoryEmployeeLog;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'givenname' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:1'],
            'email' => ['required', 'email'],
            'DOB' => ['date'],
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
        $user_count = User::all()->count();
        $access_level = $user_count > 0 ? 2 : 1;

        $user = User::create([
            'username' => $data['username'],
            'access_level' => $access_level,
            'password' => Hash::make($data['password']),
            'isactive' => 1,
        ]);

        $user_profile = UsersProfile::create([
            'user_id' => $user->id,
            'firstname' => $data['givenname'],
            'middlename' => $data['middlename'] ?? NULL,
            'email' => $data['email'],
            'lastname' => $data['surname'],
            'gender_id' => $data['gender'],
            'online_course_id' => 1,
            'DOB' => $data['DOB'],
        ]);

        if ($user_profile) {
            InventoryEmployeeLog::create([
                'user_id' => $user->id,
                'time_in' => date('Y-m-d h:i:s'),
            ]); 
        }
        
        return $user;
    }
}
