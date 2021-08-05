<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

use App\M_Admin;

class Pengadaan extends Controller
{
    public function index(){
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token', $token)->count();
        if($tokenDb > 0){
            $data['token'] = $token;
            return view('pengadaan.list', $data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }
}
