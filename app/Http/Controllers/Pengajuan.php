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
use App\M_Pengadaan;
use App\M_Laporan;

class Pengajuan extends Controller
{
    public function pengajuan(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $pengajuan = M_Pengajuan::where('status', '1')->paginate(15);
            $dataP = array();
            foreach($pengajuan as $p){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $p->id_pengadaan)->first();
                $sup = M_Suplier::where('id_suplier', $p->id_suplier)->first();
                $dataP[] = array(
                    "id_pengajuan" => $p->id_pengajuan,
                    "nama_pengadaan" => $pengadaan->nama_pengadaan,
                    "gambar" => $pengadaan->gambar,
                    "anggaran" => $pengadaan->anggaran,
                    "proposal" => $p->proposal,
                    "anggaran_pengajuan" => $p->anggaran,
                    "status_pengajuan" => $p->status,
                    "nama_suplier" => $sup->nama_usaha,
                    "email_suplier" => $sup->email,
                    "alamat_suplier" => $sup->alamat
                );
            }
            $data['pengajuan'] = $dataP;
            return view('pengajuan.list', $data);
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

    public function terimaPengajuan($id){
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb > 0) {
            if(M_Pengajuan::where('id_pengajuan',$id)->update(
                [
                    "status" => "2"
                ]
            )){
                return redirect('/pengajuan')->with('berhasil', 'Status Pengajuan Berhasil Dirubah');
            }else{
                return redirect('/pengajuan')->with('gagal', 'Status Pengajuan Gagal Dirubah');
            }
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda silahkan login dahulu');
        }
    }

    public function tolakPengajuan($id){
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb > 0) {
            if(M_Pengajuan::where('id_pengajuan',$id)->update(
                [
                    "status" => "0"
                ]
            )){
                return redirect('/pengajuan')->with('berhasil', 'Status Pengajuan Berhasil Dirubah');
            }else{
                return redirect('/pengajuan')->with('gagal', 'Status Pengajuan Gagal Dirubah');
            }
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda silahkan login dahulu');
        }
    }
    public function riwayatku(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Suplier::where('token', $token)->count();
        $decode = JWT::decode($token, $key, array('HS256'));
        $decode_array = (array) $decode;
        if ($tokenDb > 0) {
            $pengajuan = M_Pengajuan::where('id_suplier', $decode_array['id_suplier'])->get();
            $dataArr = array();
            foreach($pengajuan as $p){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $p->id_pengadaan)->first();
                $sup = M_Suplier::where('id_suplier', $decode_array['id_suplier'])->first();
                $lapCount = M_Laporan::where('id_pengajuan', $p->id_pengajuan)->count();
                $lap = M_Laporan::where('id_pengajuan', $p->id_pengajuan)->first();
                if($lapCount > 0){
                    $lapLink = $lap->laporan;
                }else{
                    $lapLink = "-";
                }

                $dataArr[] = array(
                    "id_pengajuan" => $p->id_pengajuan,
                    "nama_pengadaan" => $pengadaan->nama_pengadaan,
                    "gambar" => $pengadaan->gambar,
                    "anggaran" => $pengadaan->anggaran,
                    "proposal" => $p->proposal,
                    "anggaran_pengajuan" => $p->anggaran,
                    "status_pengajuan" => $p->status,
                    "nama_suplier" => $sup->nama_usaha,
                    "email_suplier" => $sup->email,
                    "alamat_suplier" => $sup->alamat,
                    "laporan" => $lapLink

                );
            }
            $data['pengajuan'] = $dataArr;
                return view('suplier.riwayat_pengajuan', $data);
        }else{
            return redirect('/masukSuplier')->with('gagal', 'Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }
    public function tambahLaporan(Request $request)
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
                    'id_pengajuan' => 'required',
                    'laporan' => 'required|mimes:pdf,PDF|max:10000'
                ]
            );
            $cekLaporan = M_Laporan::where('id_suplier', $decode_array['id_suplier'])->where('id_pengajuan', $request->id_pengajuan)->count();
            if($cekLaporan == 0){
                $path = $request->file('laporan')->store('public/laporan');
                if (M_Laporan::create(
                    [
                        "id_pengajuan" => $request->id_pengajuan,
                        "id_suplier" => $decode_array['id_suplier'],
                        "laporan" => $path,
                    ]
                )) {
                    return redirect('/riwayatku')->with('berhasil', 'Laporan Berhasil Diupload');
                } else {
                    return redirect('/riwayatku')->with('gagal', 'Laporan Gagal Diupload');    
                }
            }else{
                return redirect('/riwayatku')->with('gagal', 'Laporan sudah pernah Diupload');
            }
            
        } else {
            return redirect('/masukSuplier')->with('gagal', 'Anda sudah Logout, silahkan login kembali untuk masuk aplikasi');
        }
    }
    public function laporan(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDb = M_Admin::where('token',$token)->count();

        if($tokenDb > 0){
            $pengajuan = M_Pengajuan::where('status', '2')->paginate(15);
            $dataP = array();
            foreach($pengajuan as $p){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $p->id_pengadaan)->first();
                $sup = M_Suplier::where('id_suplier', $p->id_suplier)->first();
                $c_laporan = M_Laporan::where('id_pengajuan', $p->id_pengajuan)->count();
                $laporan = M_Laporan::where('id_pengajuan', $p->id_pengajuan)->first();
                if($c_laporan > 0){
                    $dataP[] = array(
                        "id_pengajuan" => $p->id_pengajuan,
                        "nama_pengadaan" => $pengadaan->nama_pengadaan,
                        "gambar" => $pengadaan->gambar,
                        "anggaran" => $pengadaan->anggaran,
                        "proposal" => $p->proposal,
                        "anggaran_pengajuan" => $p->anggaran,
                        "status_pengajuan" => $p->status,
                        "nama_suplier" => $sup->nama_usaha,
                        "email_suplier" => $sup->email,
                        "alamat_suplier" => $sup->alamat,
                        "laporan" => $laporan->laporan
                    );
                }else{
                    
                }

                
            }
            $data['pengajuan'] = $dataP;
            return view('admin.laporan', $data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Anda silahkan login dahulu');
        }
    }
}
