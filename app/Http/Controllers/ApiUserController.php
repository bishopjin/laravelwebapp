<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApiUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\UsersLoggedIn;

class ApiUserController extends Controller
{
    public function register(ApiUserRequest $request)
    {
        $response = array('id' => '0', 'msg' => array('message' => 'Failed'));

        if ($request->validated()) {
            $user = User::create($request->validated());

            if ($user->id > 0) {
                event(new UsersLoggedIn($user, 'login'));
                $response = array('id' => $user->id > 0 ?  '1' : '0', 'msg' => array('message' => 'Successful'));
            }
        } 

        return $response;
    }

    public function login(Request $request) 
    {
        $response = array('role' => [], 'token' => 'Access Denied', 'id' => 0, 'permission' => []);

        $credentials = $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        $user = User::withTrashed()->where('username', $credentials['username'])->first();

        if ($user AND $user->deleted_at != null) {
            $response = array('role' => [], 'token' => 'User is not active', 'id' => 0, 'permission' => []);

        } else {
            if (Auth::attempt($credentials)) {          
                $permissions = [];
                
                if (auth()->user()->getPermissionsViaRoles()->count() > 0) {
                    foreach (auth()->user()->getPermissionsViaRoles() as $permission) {
                        array_push($permissions, $permission->name);
                    }
                }

                $response = array(
                    'role' => auth()->user()->getRoleNames(), 
                    'token' => auth()->user()->createToken($request->input('origin'), $permissions)->plainTextToken, 
                    'id' => auth()->user()->id, 
                    'permission' => $permissions
                );

                event(new UsersLoggedIn($user, 'login'));

            } else {
                $response = array(
                    'role' => [], 
                    'token' => 'The provided credentials do not match our records.', 
                    'id' => 0, 
                    'permission' => []);
            }
        }
        
        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        event(new UsersLoggedIn($request->user(), 'logout'));

        return response()->json(['message' => 'User\'s Logged out.']);
    }
}
