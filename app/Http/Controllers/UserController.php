<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Toko;
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
        try{
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
            User::create($fordatabase);
            return redirect('/login');
        }catch(Exception){
            return back();
        }
    }

    public function userLoginAuth(Request $request){
        if(is_numeric($request->emailOrPhone)){
            $finaldata = $request->validate([
                'emailOrPhone' => 'required|numeric',
                'password' => 'required'
            ]);
            $checkData = [
                'telepon' => $finaldata['emailOrPhone'],
                'password' => $finaldata['password']
            ];
            if (Auth::attempt($checkData)) {
                $request->session()->regenerate();
                return redirect('/');
            }
        }else {
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
        }

        return redirect('/login');
    }

    public function viewBuatToko(){
        if( count(Toko::where('user_id', auth()->user()->id)->get()) > 0 ){
            return redirect('/toko/dashboard');
        }
        return view('buatToko',[
            'title' => 'Buat Toko Gratis | Warpedia',
            'css' => 'buattoko.css',
            'js' => 'buattoko.js'
            
        ]);
    }

    public function checkNamaToko(Request $request){
        $namatoko = strtolower(strval($request->name));
        // CHECK THE WORD
        if(strlen($request->name) <= 0 || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->name)){
            return false;
        }
        
        $getData = Toko::where('nama_toko', $namatoko)->get();
        if(count($getData) === 0){
            return ['success' => 'Nama ini tersedia!'];
        }else{
            return ['fail' => 'Maaf nama ini sudah terpakai'];
        }

    }

    

}