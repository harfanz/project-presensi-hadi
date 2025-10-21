<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {   
        $hariini = date("Y-m-d");
        $id_pkl = Auth::guard('users')->user()->id_pkl;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('id_pkl', $id_pkl)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('presensi.create', compact('cek','lok_kantor'));
    }

    // public function store(Request $request){
    //     $id_pkl = Auth::guard('users')->user()->id_pkl;
    //     $tgl_presensi =  date("Y-m-d");
    //     $jam = date('H:i:s');
        
    //     $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
    //     $lok = explode(",",$lok_kantor->lokasi_kantor);
        
    //     $latitudekantor = $lok[0];
    //     $longitudekantor = $lok[1]; 
      
    //     $lokasi = $request->lokasi; 
    //     $lokasiuser = explode(",",$lokasi);
    //     $latitudeuser = $lokasiuser[0];
    //     $longitudeuser = $lokasiuser[1];

    //     $jarak = $this->distance($latitudekantor,$longitudekantor,$latitudeuser,$longitudeuser);
    //     $radius = round($jarak["meters"]);

        

    //     $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('id_pkl', $id_pkl)->count();

    //     if($cek > 0){
    //         $ket = "out";
    //     }else{
    //         $ket = "in";
    //     }
    //     $image = $request->image;   
    //     $folderPath = "public/uploads/absensi/";
    //     $formatName = $id_pkl ."-". $tgl_presensi."-".$ket;
    //     $image_parts = explode(";base64", $image);
    //     $image_base64 = base64_decode($image_parts[1]);
    //     $fileName = $formatName . ".png";
    //     $file = $folderPath . $fileName;
    //     $data = [
    //         'id_pkl' => $id_pkl,
    //         'tgl_presensi' => $tgl_presensi,
    //         'jam_in' => $jam,
    //         'foto_in' => $fileName,
    //         'lokasi_in' => $lokasi
    //     ];
         
    //      if($radius > $lok_kantor->radius){
    //         echo "error|Maaf Anda berada diluar radius, Jarak Anda adalah ".$radius." Meter dari kantor|radius";
    //      }else{

    //      if($cek > 0){
    //         $data_pulang= [
            
    //         'jam_out' => $jam,
    //         'foto_out' => $fileName,
    //         'lokasi_out' => $lokasi
    //     ];
    //         $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('id_pkl', $id_pkl)->update($data_pulang);
    //         if($update){
    //         echo "success|Terimakasih, hati-hati di jalan|out";
    //          Storage::put($file, $image_base64);
    //     }else{
    //         echo "error|Maaf Gagal Absen, Hubungi admin|out";
    //          }
    //      }else{
    //             $data = [
    //         'id_pkl' => $id_pkl,
    //         'tgl_presensi' => $tgl_presensi,
    //         'jam_in' => $jam,
    //         'foto_in' => $fileName,
    //         'lokasi_in' => $lokasi
    //     ];



    //     $simpan = DB::table('presensi')->insert($data);
    //     if($simpan){
    //         echo "success|Terimakasih, selamat PKL|in";
    //          Storage::put($file, $image_base64);
    //     }else{
    //         echo "error|Maaf Gagal Absen, Hubungi admin|in";
    //     }
    //      }
    //     }
    // 
    // }

    public function store(Request $request){
    $id_pkl = Auth::guard('users')->user()->id_pkl;
    $tgl_presensi =  date("Y-m-d");
    $jam = date('H:i:s');
    
    $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
    $lok = explode(",",$lok_kantor->lokasi_kantor);
    
    $latitudekantor = $lok[0];
    $longitudekantor = $lok[1]; 
  
    $lokasi = $request->lokasi; 
    $lokasiuser = explode(",",$lokasi);
    $latitudeuser = $lokasiuser[0];
    $longitudeuser = $lokasiuser[1];

    $jarak = $this->distance($latitudekantor,$longitudekantor,$latitudeuser,$longitudeuser);
    $radius = round($jarak["meters"]);

    $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('id_pkl', $id_pkl)->count();
    
    // tentukan status "in" atau "out"
    if($cek > 0){
        $ket = "out";
    }else{
        $ket = "in";
    }

    $image = $request->image;   
    $folderPath = "public/uploads/absensi/";
    $formatName = $id_pkl ."-". $tgl_presensi."-".$ket;
    $image_parts = explode(";base64", $image);
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = $formatName . ".png";
    $file = $folderPath . $fileName;

    if($radius > $lok_kantor->radius){
        echo "error|Maaf Anda berada diluar radius, Jarak Anda adalah ".$radius." Meter dari kantor|radius";
    }else{
        if($cek > 0){
            // **ambil data presensi yang sudah ada**
            $presensi = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('id_pkl', $id_pkl)->first();

            // **cek apakah jam_out sudah ada**
            if(!empty($presensi->jam_out)){
                echo "error|Kamu sudah melakukan absen pulang hari ini|done";
            }else{
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('id_pkl', $id_pkl)->update($data_pulang);
                if($update){
                    echo "success|Terimakasih, hati-hati di jalan|out";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Maaf Gagal Absen, Hubungi admin|out";
                }
            }

        }else{
            $data = [
                'id_pkl' => $id_pkl,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'lokasi_in' => $lokasi
            ];

            $simpan = DB::table('presensi')->insert($data);
            if($simpan){
                echo "success|Terimakasih, selamat PKL|in";
                Storage::put($file, $image_base64);
            }else{
                echo "error|Maaf Gagal Absen, Hubungi admin|in";
            }
        }
    }
}


    // fungsi ini adalah untuk menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile(){

        $id_pkl = Auth::guard('users')->user()->id_pkl;
        $users = DB::table('users')->where('id_pkl', $id_pkl)->first();
     
        return view ('presensi.editprofile',compact('users'));
    }
    
    public function updateprofile(Request $request){
        $id_pkl = Auth::guard('users')->user()->id_pkl;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $users = DB::table('users')->where('id_pkl', $id_pkl)->first();
        if($request->hasFile('foto')){
            $foto = $id_pkl.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $users->foto;
        }
        
        if(empty($password)){
             $data = [

                 'nama_lengkap' => $nama_lengkap,
                 'no_hp' => $no_hp,
                 'foto' => $foto
             ];
             }else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('users')->where('id_pkl', $id_pkl)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/users/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success'=>'Data Berhasil di Update']);
        }else{
            return Redirect::back()->with(['error'=>'Data Gagal di Update']);
        }

       
    }


     public function histori()
    {
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","november","Desember"];
        return view('presensi.histori',compact('namabulan'));
    }

    public function gethistori(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pkl = Auth::guard('users')->user()->id_pkl;

        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="' .$bulan. '"')
        ->whereRaw('YEAR(tgl_presensi)="' .$tahun. '"')
        ->where('id_pkl', $id_pkl)
        ->get();

        
       return view('presensi.gethistori', compact('histori'));
    }


    public function izin(){
         $id_pkl = Auth::guard('users')->user()->id_pkl;
        $dataizin = DB::table('pengajuan_izin')->where('id_pkl', $id_pkl)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin(){
       
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request){
        $id_pkl = Auth::guard('users')->user()->id_pkl;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

      if($request->hasFile('tanda_bukti')){
        $file = $request->file('tanda_bukti'); // ambil file asli
        $fileName = $id_pkl . "-" . $tgl_izin . "." . $file->getClientOriginalExtension(); // nama file
        $file->storeAs('public/uploads/tandabukti', $fileName); // simpan ke storage
    } else {
        $fileName = null; 
    }
       
        $data = [

            'id_pkl' => $id_pkl,
            'tgl_izin' => $tgl_izin,
            'status' => $status,    
            'keterangan' => $keterangan,
            'tanda_bukti' => $fileName
        
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if($simpan){
            //  Storage::put($file, $formatName);
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
           
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
            
        }

    }
    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap','nama_dept')
        ->join('users','presensi.id_pkl','users.id_pkl')
        ->join('departemen','users.kode_dept','departemen.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function tampilkanpeta(Request $request){
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
        ->join('users', 'presensi.id_pkl', '=', 'users.id_pkl')
        ->first();
        return view('presensi.showmap',compact('presensi'));
    }

    public function laporan(){
         $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","november","Desember"];
         $user = DB::table('users')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan',compact('namabulan','user'));
    }

    // public function cetaklaporan(Request $request){
    //     $id_pkl = $request->id_pkl;
    //     $bulan = $request->bulan;
    //     $tahun = $request->tahun;
    //      $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","november","Desember"];
    //      $user = DB::table('users')->where('id_pkl', $id_pkl)
    //      ->join('departemen','users.kode_dept','=','departemen.kode_dept')
    //      ->first();

    //      $presensi = DB::table('presensi')
    //      ->where('id_pkl', $id_pkl)
    //      ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
    //      ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
    //      ->where('accept', 1)
    //      ->orderBy('tgl_presensi')
    //      ->get();

    //      if(isset($_POST['exportexcel'])){
    //      $time = date("d-M-Y H:i:s");
         
    //     header("Content-type: application/vnd-ms-excel");
    //     header("Content-Disposition: attachment; filename=Laporan $time.xls");
    //      return view('presensi.cetaklaporanexcel', compact('bulan','tahun', 'namabulan','user','presensi'));
    //       }else{
    //     return view('presensi.cetaklaporan', compact('bulan','tahun', 'namabulan','user','presensi'));
    // }}

    public function cetaklaporan(Request $request)
{
    $id_pkl = $request->id_pkl;
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

    // 🔹 Ambil data user
    $user = DB::table('users')
        ->where('id_pkl', $id_pkl)
        ->join('departemen','users.kode_dept','=','departemen.kode_dept')
        ->first();

    // 🔹 Ambil data presensi yang sudah disetujui
    $presensi = DB::table('presensi')
        ->where('id_pkl', $id_pkl)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('accept', 1)
        ->orderBy('tgl_presensi')
        ->get();

    // 🔹 Tambahkan data izin/sakit yang sudah di-approve
    $izin = DB::table('pengajuan_izin')
        ->where('id_pkl', $id_pkl)
        ->whereRaw('MONTH(tgl_izin)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_izin)="'.$tahun.'"')
        ->where('status_approved', 1)
        ->select(
            'tgl_izin as tgl_presensi',
            DB::raw('NULL as jam_in'),
            DB::raw('NULL as jam_out'),
            DB::raw('NULL as foto_in'),
            DB::raw('NULL as foto_out'),
            'keterangan',
            'status'
        )
        ->get();

    // 🔹 Gabungkan data presensi dan izin/sakit
    $presensi = $presensi->concat($izin)->sortBy('tgl_presensi')->values();

    // 🔹 Export Excel atau tampilkan PDF
    if (isset($_POST['exportexcel'])) {
        $time = date("d-M-Y H:i:s");
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan $time.xls");
        return view('presensi.cetaklaporanexcel', compact('bulan','tahun','namabulan','user','presensi'));
    } else {
        return view('presensi.cetaklaporan', compact('bulan','tahun','namabulan','user','presensi'));
    }
}


    

     public function rekap(){
         $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","november","Desember"];
        return view('presensi.rekap',compact('namabulan'));
    }
    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
         $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","november","Desember"];
    //     $rekap = DB::table('presensi')
    //     ->selectRaw('presensi.id_pkl,nama_lengkap,
    //     MAX(IF(DAY(tgl_presensi) = 1,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
    //     MAX(IF(DAY(tgl_presensi) = 2,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
    //     MAX(IF(DAY(tgl_presensi) = 3,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
    //     MAX(IF(DAY(tgl_presensi) = 4,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
    //     MAX(IF(DAY(tgl_presensi) = 5,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
    //     MAX(IF(DAY(tgl_presensi) = 6,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
    //     MAX(IF(DAY(tgl_presensi) = 7,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
    //     MAX(IF(DAY(tgl_presensi) = 8,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
    //     MAX(IF(DAY(tgl_presensi) = 9,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
    //     MAX(IF(DAY(tgl_presensi) = 10,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
    //     MAX(IF(DAY(tgl_presensi) = 11,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
    //     MAX(IF(DAY(tgl_presensi) = 12,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
    //     MAX(IF(DAY(tgl_presensi) = 13,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
    //     MAX(IF(DAY(tgl_presensi) = 14,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
    //     MAX(IF(DAY(tgl_presensi) = 15,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
    //     MAX(IF(DAY(tgl_presensi) = 16,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
    //     MAX(IF(DAY(tgl_presensi) = 17,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
    //     MAX(IF(DAY(tgl_presensi) = 18,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
    //     MAX(IF(DAY(tgl_presensi) = 19,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
    //     MAX(IF(DAY(tgl_presensi) = 20,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
    //     MAX(IF(DAY(tgl_presensi) = 21,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
    //     MAX(IF(DAY(tgl_presensi) = 22,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
    //     MAX(IF(DAY(tgl_presensi) = 23,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
    //     MAX(IF(DAY(tgl_presensi) = 24,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
    //     MAX(IF(DAY(tgl_presensi) = 25,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
    //     MAX(IF(DAY(tgl_presensi) = 26,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
    //     MAX(IF(DAY(tgl_presensi) = 27,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
    //     MAX(IF(DAY(tgl_presensi) = 28,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
    //     MAX(IF(DAY(tgl_presensi) = 29,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
    //     MAX(IF(DAY(tgl_presensi) = 30,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
    //     MAX(IF(DAY(tgl_presensi) = 31,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31 
    //     ')
    // ->join('users','presensi.id_pkl','=','users.id_pkl')
    // ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
    // ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
    // ->groupByRaw('presensi.id_pkl,nama_lengkap')
    // ->get();

   $rekap = DB::table('users')
    ->leftJoin('presensi', function ($join) use ($bulan, $tahun) {
        $join->on('users.id_pkl', '=', 'presensi.id_pkl')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->where('presensi.accept', 1); // hanya presensi yang disetujui
    })
    ->leftJoin('pengajuan_izin', function ($join) use ($bulan, $tahun) {
        $join->on('users.id_pkl', '=', 'pengajuan_izin.id_pkl')
            ->whereRaw('MONTH(tgl_izin) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_izin) = ?', [$tahun])
            ->where('pengajuan_izin.status', 'disetujui'); // hanya izin disetujui
    })
    ->selectRaw('
        users.id_pkl,
        users.nama_lengkap,

        MAX(IF(DAY(tgl_presensi)=1, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=1,"IZIN",""))) AS tgl_1,
        MAX(IF(DAY(tgl_presensi)=2, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=2,"IZIN",""))) AS tgl_2,
        MAX(IF(DAY(tgl_presensi)=3, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=3,"IZIN",""))) AS tgl_3,
        MAX(IF(DAY(tgl_presensi)=4, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=4,"IZIN",""))) AS tgl_4,
        MAX(IF(DAY(tgl_presensi)=5, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=5,"IZIN",""))) AS tgl_5,
        MAX(IF(DAY(tgl_presensi)=6, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=6,"IZIN",""))) AS tgl_6,
        MAX(IF(DAY(tgl_presensi)=7, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=7,"IZIN",""))) AS tgl_7,
        MAX(IF(DAY(tgl_presensi)=8, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=8,"IZIN",""))) AS tgl_8,
        MAX(IF(DAY(tgl_presensi)=9, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=9,"IZIN",""))) AS tgl_9,
        MAX(IF(DAY(tgl_presensi)=10, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=10,"IZIN",""))) AS tgl_10,
        MAX(IF(DAY(tgl_presensi)=11, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=11,"IZIN",""))) AS tgl_11,
        MAX(IF(DAY(tgl_presensi)=12, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=12,"IZIN",""))) AS tgl_12,
        MAX(IF(DAY(tgl_presensi)=13, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=13,"IZIN",""))) AS tgl_13,
        MAX(IF(DAY(tgl_presensi)=14, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=14,"IZIN",""))) AS tgl_14,
        MAX(IF(DAY(tgl_presensi)=15, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=15,"IZIN",""))) AS tgl_15,
        MAX(IF(DAY(tgl_presensi)=16, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=16,"IZIN",""))) AS tgl_16,
        MAX(IF(DAY(tgl_presensi)=17, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=17,"IZIN",""))) AS tgl_17,
        MAX(IF(DAY(tgl_presensi)=18, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=18,"IZIN",""))) AS tgl_18,
        MAX(IF(DAY(tgl_presensi)=19, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=19,"IZIN",""))) AS tgl_19,
        MAX(IF(DAY(tgl_presensi)=20, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=20,"IZIN",""))) AS tgl_20,
        MAX(IF(DAY(tgl_presensi)=21, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=21,"IZIN",""))) AS tgl_21,
        MAX(IF(DAY(tgl_presensi)=22, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=22,"IZIN",""))) AS tgl_22,
        MAX(IF(DAY(tgl_presensi)=23, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=23,"IZIN",""))) AS tgl_23,
        MAX(IF(DAY(tgl_presensi)=24, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=24,"IZIN",""))) AS tgl_24,
        MAX(IF(DAY(tgl_presensi)=25, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=25,"IZIN",""))) AS tgl_25,
        MAX(IF(DAY(tgl_presensi)=26, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=26,"IZIN",""))) AS tgl_26,
        MAX(IF(DAY(tgl_presensi)=27, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=27,"IZIN",""))) AS tgl_27,
        MAX(IF(DAY(tgl_presensi)=28, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=28,"IZIN",""))) AS tgl_28,
        MAX(IF(DAY(tgl_presensi)=29, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=29,"IZIN",""))) AS tgl_29,
        MAX(IF(DAY(tgl_presensi)=30, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=30,"IZIN",""))) AS tgl_30,
        MAX(IF(DAY(tgl_presensi)=31, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),
            IF(DAY(tgl_izin)=31,"IZIN",""))) AS tgl_31,

        COUNT(DISTINCT presensi.id) AS total_hadir,
        COUNT(DISTINCT pengajuan_izin.id) AS total_izin
    ')
    ->groupBy('users.id_pkl', 'users.nama_lengkap')
    ->orderBy('users.nama_lengkap', 'asc')
    ->get();


    // Ambil data izin yang sudah disetujui
    $izin = DB::table('pengajuan_izin')
    ->where('status_approved', 1)
    ->select('id_pkl', 'tgl_izin', 'status')
    ->get();

// Tambahkan ke compact agar bisa dipakai di blade

    


    if(isset($_POST['exportexcel'])){
    $time = date("d-M-Y H:i:s");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Rekap_Presensi_$time.xls");
    }
    return view('presensi.cetakrekap',compact('bulan','tahun','namabulan','rekap','izin'));
    }

    // $time = date("d-M-Y H:i:s");
    public function izinsakit(Request $request){
        $query = Pengajuanizin::query();
        $query ->select('id','tgl_izin','pengajuan_izin.id_pkl','nama_lengkap','sekolah','status','status_approved','keterangan','tanda_bukti');
        $query->join('users','pengajuan_izin.id_pkl','=','users.id_pkl');
        if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_izin',[$request->dari,$request->sampai]);
        }

        if(!empty($request->id_pkl)){
            $query->where('pengajuan_izin.id_pkl',$request->id_pkl);
        }

        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap','like','%'.$request->nama_lengkap.'%');
        }

        if($request->status_approved != ""){
            $query->where('status_approved',$request->status_approved);
        }
        $query->orderBy('tgl_izin','desc');
        $izinsakit = $query->paginate(5);
        $izinsakit->appends($request->all());
        return view('presensi.izinsakit',compact('izinsakit'));
    }
    public function approveizinsakit(Request $request){
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $balasan = $request->balasan;


        $update = DB::table('pengajuan_izin')
        ->where('id', $id_izinsakit_form)
        
        ->update([
            'status_approved' => $status_approved,
            'balasan' => $balasan,
        ]);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        }
    }

    public function batalkanizinsakit($id){
        $update = DB::table('pengajuan_izin')->where('id',$id)->update([
            'status_approved' => 0
        ]);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        }
    }

    public function cekpengajuanizin(Request $request){
        $tgl_izin = $request->tgl_izin;
        $id_pkl = Auth::guard('users')->user()->id_pkl;

        $cek = DB::table('pengajuan_izin')->where('id_pkl', $id_pkl)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }

    public function approveAbsen(Request $request)
{
    $id = $request->id;
    $status = $request->status;
     

    DB::table('presensi')
        ->where('id', $id)
        ->update(['accept' => $status]);
    
    return response()->json(['success' => true]);
} 


public function cancel(Request $request)
{
    $id = $request->id;
    DB::table('presensi')->where('id', $id)->update([
        'accept' => 0
    ]);

    return response()->json(['success' => true]);
}

}
