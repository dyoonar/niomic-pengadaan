<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;

use App\M_Admin;
use App\M_Pengadaan;

class Pengadaan extends Controller
{
    public function index(){
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token', $token)->count();
        if($tokenDb > 0){
            $data['pengadaan'] = M_Pengadaan::where('status','1')->paginate(15);
            return view('pengadaan.list', $data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }

    public function tambahPengadaan(Request $request){
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token', $token)->count();
        if($tokenDb > 0){
            $this->validate($request,
            [
                'nama_pengadaan' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'required|image|mimes:jpg,JPG,png,PNG,jpeg,JPEG|max:10000',
                'anggaran' => 'required',
            ]
            );
            $path = $request->file('gambar')->store('public/gambar');
            if(M_Pengadaan::create(
                [
                    "nama_pengadaan" => $request->nama_pengadaan,
                    "deskripsi" => $request->deskripsi,
                    "gambar" => $path,
                    "anggaran" => $request->anggaran
                ]
            )){
                return redirect('/listPengadaan')->with('berhasil','Data Berhasil di Simpan');
            }else{
                return redirect('/listPengadaan')->with('gagal','Data Gagal di Simpan');
            }

        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }

    public function hapusGambar($id){

        $token = Session::get('token');
        $tokenDb = M_Admin::where('token', $token)->count();
        if($tokenDb > 0){
            $pengadaan = M_Pengadaan::where('id_pengadaan', $id)->count();
            if($pengadaan > 0){
                $dataPengadaan = M_Pengadaan::where('id_pengadaan', $id)->first();
                if(Storage::delete($dataPengadaan->gambar)){
                    if(M_Pengadaan::where('id_pengadaan', $id)->update([
                        "gambar"=> "-"
                    ])){
                        return redirect('/listPengadaan')->with('berhasil','Gambar Berhasil di Hapus');
                    }else{
                        return redirect('/listPengadaan')->with('gagal','Gambar Gagal di Hapus');
                    }
                }else{
                    return redirect('/listPengadaan')->with('gagal','Gambar Gagal di Hapus');
                }
            }else{
                return redirect('/listPengadaan')->with('gagal','Data Tidak Ditemukan');
            }
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }
}
