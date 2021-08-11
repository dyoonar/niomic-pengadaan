<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

use App\M_Admin;
use App\M_Pengajuan;
use App\M_Suplier;

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

    public function tambahPengajuan(Request $request)
    {
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Suplier::where('token', $token)->count();
        $decode = JWT::decode($token, $key, array('HS256'));
        $decode_array = (array) $decode;
        if ($tokenDb > 0) {
            $this->validate(
                $request,
                [
                    'id_pengadaan' => 'required',
                    'proposal' => 'required|mimes:pdf,PDF|max:10000',
                    'anggaran' => 'required',
                ]
            );
            $cekpengajuan = M_Pengajuan::where('id_suplier', $decode_array['id_suplier'])->where('id_pengadaan', $request->id_pengadaan)->count();
            if($cekpengajuan == 0){
                $path = $request->file('proposal')->store('public/proposal');
                if (M_Pengajuan::create(
                    [
                        "id_pengadaan" => $request->id_pengadaan,
                        "id_suplier" => $decode_array['id_suplier'],
                        "proposal" => $path,
                        "anggaran" => $request->anggaran
                    ]
                )) {
                    return redirect('/listSuplier')->with('berhasil', 'Pengajuan Berhasil, mohon ditunggu');
                } else {
                    return redirect('/listSuplier')->with('gagal', 'Pengajuan Gagal, Hubungi Admin');    
                }
            }else{
                return redirect('/listSuplier')->with('gagal', 'Pengajuan sudah pernah dilakukan');
            }
            
        } else {
            return redirect('/masukSuplier')->with('gagal', 'Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }
}
