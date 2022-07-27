<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function ViewUserRegister(){
        return view('auth.register', [
            'title' => 'Warpedia | Daftar',
            'css' => 'register.css',
            'js' => 'register.js'
        ]);
    }
    public function viewUserLogin(){
        return view('auth.login', [
            'title' => 'Warpedia | Masuk',
            'css' => 'login.css',
            'js' => 'login.js'
        ]);
    }

    // AUTH REGISTER
    public function userRegisterAuth(Request $request){
        // try{
            if(is_int($request->emailOrNumber)){
                $finaldata = $request->validate([
                    'username' => 'required|max:250|regex:/^[a-zA-Z]+$/u',
                    'emailOrNumber' => 'required|numeric|max:250',
                    'password' => 'required|min:8|max:100'
                ]);
            }else {
                $finaldata = $request->validate([
                    'username' => 'required|max:250|regex:/^[a-zA-Z]+$/u',
                    'emailOrNumber' => 'required|max:250',
                    'password' => 'required|min:8|max:100'
                ]);
            }
            $finaldata['password'] = Hash::make($finaldata['password']);
        
            $fordatabase = [
                'email' => $request->emailOrNumber,
                'username' => $request->username,
                'password' => $finaldata['password'],
                'address' => 'null',
                'telepon' => 'null'
            ];
            if(is_numeric($request->emailOrNumber)){
                $fordatabase['telepon'] = $request->emailOrNumber;
                $fordatabase['email'] = ' ';
            }
            return $fordatabase;
            User::create($fordatabase);
            return redirect('/login');
        // }catch(Exception){
        //     return back();
        // }
    }

    public function userLoginAuth(Request $request){
        $finaldata = $request->validate([
            'emailOrPhone' => 'required|email',
            'password' => 'required'
        ]);
        $checkData = [
            'email' => $finaldata['emailOrPhone'],
            'password' => $finaldata['password']
        ];
        
        if (Auth::attempt($checkData)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/login');
    }


}
