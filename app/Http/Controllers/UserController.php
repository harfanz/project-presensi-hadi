<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
        $query = User::query();
        $query->select('users.*', 'nama_dept');
        $query->join('departemen','users.kode_dept','=','departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_siswa)){
            $query->where('nama_lengkap','like','%'. $request->nama_siswa . '%');
        }
        if(!empty($request->kode_dept)){
            $query->where('users.kode_dept', $request->kode_dept);
        }
        $user = $query->paginate(10);

        $departemen = DB::table('departemen')->get();
        return view('user.index',compact('user','departemen'));
    }
    public function store(Request $request){
        $id_pkl = $request->id_pkl;
        $nama_lengkap = $request->nama_lengkap;
        $sekolah = $request->sekolah;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        if($request->hasFile('foto')){
            $foto = $id_pkl.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        };

        try{
            $data = [
                'id_pkl' => $id_pkl,
                'nama_lengkap' => $nama_lengkap,
                'sekolah' => $sekolah,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
            ];
            $simpan = DB::table('users')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/users/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success'  => 'Data Berhasil di Simpan']);
            }
        }catch(Exception $e){
            
            return Redirect::back()->with(['warning'  => 'Data Gagal di simpan']);
            // dd($e->message);
            
        };
    }
    public function edit(Request $request)
    {
        $id_pkl = $request->id_pkl;
        $departemen = DB::table('departemen')->get();
        $user = DB::table('users')->where('id_pkl', $id_pkl)->first();
        return view('user.edit', compact('departemen','user'));
    }
    public function update($id_pkl, Request $request){
         $id_pkl = $request->id_pkl;
        $nama_lengkap = $request->nama_lengkap;
        $sekolah = $request->sekolah;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $id_pkl.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        };

        try{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'sekolah' => $sekolah,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
            ];
            $update = DB::table('users')->where('id_pkl', $id_pkl)->update($data);
            if($update){
                if($request->hasFile('foto')){

                    $folderPath = "public/uploads/users/";
                    $folderPathOld = "public/uploads/users/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success'  => 'Data Berhasil di Update']);
            }
        }catch(Exception $e){
            return Redirect::back()->with(['warning'  => 'Data Gagal di Update']);
            // dd($e->message);
        };
    }

    public function delete($id_pkl){
        $delete = DB::table('users')->where('id_pkl', $id_pkl)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil di Hapus']);
        }else{
              return Redirect::back()->with(['warning'=>'Data Gagal di Hapus']);
        }
    }
}
