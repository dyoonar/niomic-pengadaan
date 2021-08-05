<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use App\M_Suplier;

class Home extends Controller
{
    public function index(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Suplier::where('token', $token)-> count();
        If($tokenDb > 0){
            $data['token'] = $token;

        }else{
            $data['token'] = "kosong";
        }
        return view('home.home', $data);
    }
}
