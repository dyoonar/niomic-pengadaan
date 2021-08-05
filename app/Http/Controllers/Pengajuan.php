<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

use App\M_Admin;

class Pengajuan extends Controller
{
    public function pengajuan(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            return view('pengajuan.list');
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda silahkan login dahulu');
        }

        
    }
}
