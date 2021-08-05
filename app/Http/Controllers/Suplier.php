<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

use App\M_Suplier;

class Suplier extends Controller
{
    public function index(){
        return view('suplier.login');
    }

    public function masukSuplier(Request $request){
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );
        $cek = M_Suplier::where('email',$request->email)->count();
        $sup = M_Suplier::where('email',$request->email)->get();

        if($cek > 0){
            foreach($sup as $s){
                if(decrypt($s->password) == $request->password){
                    $key = env('APP_KEY');
                    $data = array(
                        "id_suplier" => $s->id_suplier
                    );
                    $jwt = JWT::encode($data, $key);
                    M_Suplier::where('id_suplier',$s->id_suplier)->update(
                        [
                            'token' => $jwt
                        ]
                        );
                    Session::put('token',$jwt);
                    return redirect('/');
                }else{
                    return redirect('/masukSuplier')->with('gagal','Password Salah');
                }
            }
        }else{
            return redirect('/masukSuplier')->with('gagal','Data email tidak terdaftar');
        }
    }

    public function suplierKeluar(){
        $token = Session::get('token');
        if(M_Suplier::where('token', $token)-> update(
            [
                'token' => 'keluar'
            ]
        )){
            Session::put('token',"");
            return redirect('/');
        }else{
            return redirect('/masukSuplier')->with('gagal','Anda gagal logout');
        }
    }
} 
