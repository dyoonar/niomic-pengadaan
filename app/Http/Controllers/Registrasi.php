<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\M_Suplier;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Session;

class Registrasi extends Controller
{
    public function index(){
        $token = Session::get('token');
        $tokenDb = M_Suplier::where('token', $token)-> count();
        If($tokenDb > 0){
            $data['token'] = $token;

        }else{
            $data['token'] = "kosong";
        }
        return view('registrasi.registrasi', $data);
    }
    
    public function registrasi(Request $request){
        $this->validate($request,
            [
                'nama_usaha' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'no_npwp' => 'required',
                'password' => 'required'
            ]
        );

        if(
            M_Suplier::create(
                [
                    "nama_usaha" => $request->nama_usaha,
                    "email" => $request->email,
                    "alamat" => $request->alamat,
                    "no_npwp" => $request->no_npwp,
                    "password" => encrypt($request->password)
                ]
            )
        ){
            return redirect('/registrasi')->with('berhasil','Data Berhasil Di Simpan');
        }else{
            return redirect('/registrasi')->with('gagal','Data Gagal Di Simpan');
        }
    }
}
