@extends('layouts.presensi')

@section('content')
<style>
 /* Avatar user */
#user-detail .avatar img {
    border: 3px solid #ffffff !important;
    border-radius: 50% !important;
    transition: all 0.4s ease-in-out !important;
}
#user-detail .avatar img:hover {
    transform: scale(1.1) !important;
    box-shadow: 0 6px 18px rgba(255, 255, 255, 0.4) !important;
    border-color: #ffffff !important; /* emas biar kontras */
}

/* Nama user */
#user-info h2 {
    font-weight: bold !important;
    color: #ffffff !important;   /* putih biar kontras */
    transition: all 0.3s ease-in-out !important;
    position: relative;
   
}
#user-info h2:hover {
    color: #ffffff !important; 
    text-shadow: 0 0 8px rgba(255,255,255,0.8), 
                 0 0 12px rgba(255,255,255,0.6) !important; /* glow putih */
    transform: scale(1.05) !important;
}

/* Role user */
#user-info #user-role {
    color: #e0e0e0 !important; /* abu-abu muda */
    font-style: italic !important;
    transition: color 0.3s ease-in-out !important;
}
#user-info #user-role:hover {
    color: #ffffff !important; /* jadi putih saat hover */
}


/* Menu item */
.item-menu {
    transition: all 0.3s ease-in-out !important;
}
.item-menu:hover {
    transform: scale(1.1) !important;
}
.item-menu .menu-icon a {
    transition: all 0.3s ease-in-out !important;
}
.item-menu:hover .menu-icon a {
    color: #0f3a7e !important;
}

/* Card presensi masuk/pulang */
.card.gradasigreen,
.card.gradasired {
    border-radius: 12px !important;
    transition: all 0.3s ease-in-out !important;
}
.card.gradasigreen:hover,
.card.gradasired:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2) !important;
}

/* Card rekap */
#rekappresensi .card {
    border-radius: 12px !important;
    transition: all 0.3s ease-in-out !important;
}
#rekappresensi .card:hover {
    transform: scale(1.1) !important;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2) !important;
}

/* Tab nav */
.nav-tabs.style1 .nav-link {
    transition: all 0.3s ease-in-out !important;
}
.nav-tabs.style1 .nav-link:hover {
    color: #0f3a7e !important;
    font-weight: 600 !important;
    transform: scale(1.05) !important;
}

/* List item (history, leaderboard) */
.listview .item {
    transition: all 0.3s ease-in-out !important;
}
.listview .item:hover {
    background: #f3f6fc !important;
    transform: scale(1.02) !important;
    border-radius: 8px !important;
}
/* Container detail user */
#user-detail {
    display: flex;
    align-items: center;
    gap: 12px; /* jarak antara foto & teks */
    padding: 10px 15px;
}

/* Avatar */
#user-detail .avatar img {
    border: 3px solid #ffffff !important;
    border-radius: 50% !important;
    transition: all 0.4s ease-in-out !important;
    width: 60px !important;
    height: 60px !important;
    object-fit: cover;
}
#user-detail .avatar img:hover {
    transform: scale(1.1) !important;
    box-shadow: 0 6px 18px rgba(255, 215, 0, 0.5) !important;
    border-color: #ffd700 !important;
}




.logout{
    position: absolute;
    color:white;
    font-size: 30px;
    right:10px;
}


</style>
 
          <div class="section" id="user-section">
            <a href="/proseslogout" class="logout">
                <ion-icon name="log-out-outline"></ion-icon>
            </a>
            <div id="user-detail">
                <div class="avatar">
                    @if(!empty(Auth::guard('users')->user()->foto))
                    @php
                    $path = Storage::url('uploads/users/'.Auth::guard('users')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded" style="height: 60px" width="60px">
                    @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info">
                    <h2 id="user-name">{{ Auth::guard('users')->user()->nama_lengkap }}</h2>
                    <span id="user-role">{{ Auth::guard('users')->user()->seksi }}</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofile" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Izin</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/histori" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($presensihariini != null)
                                            @php
                                             $path = Storage::url('uploads/absensi/'.$presensihariini->foto_in);  
                                            @endphp
                                            <img src="{{ url($path) }}" alt="" class="imaged w48">
                                            @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($presensihariini != null && $presensihariini->jam_out !=null)
                                            @php
                                             $path = Storage::url('uploads/absensi/'.$presensihariini->foto_out);  
                                            @endphp
                                            <img src="{{ url($path) }}" alt="" class="imaged w48">
                                            @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div id="rekappresensi">
    <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                    <span class="badge bg-danger" style="position: absolute; top: 3px; right:10px; font-size: 0.6rem; z-index: 999;">{{ $rekappresensi->jmlhadir }}</span>
                    <ion-icon name="people" style="font-size: 1.6rem;" class="text-success mb-1" ></ion-icon>
                    <br>
                    <span style="font-size: 0.8rem; font-weight: 500;">Hadir</span>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                    <span class="badge bg-danger" style="position: absolute; top: 3px; right:10px; font-size: 0.6rem; z-index: 999;">{{ $rekapizin->jmlizin}}</span>
                    <ion-icon name="mail" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                     <br>
                    <span style="font-size: 0.8rem; font-weight: 500;">Izin</span>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                    <span class="badge bg-danger" style="position: absolute; top: 3px; right:10px; font-size: 0.6rem; z-index: 999;">{{ $rekapizin->jmlsakit }}</span>
                    <ion-icon name="medkit" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                     <br>
                    <span style="font-size: 0.8rem; font-weight: 500;">Sakit</span>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                    <span class="badge bg-danger" style="position: absolute; top: 3px; right:10px; font-size: 0.6rem; z-index: 999;">{{ $rekappresensi->jmlterlambat }}</span>
                    <ion-icon name="stopwatch" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                     <br>
                    <span style="font-size: 0.8rem; font-weight: 500;">Telat</span>
                </div>
            </div>
        </div>
        
    </div>
</div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            {{-- @foreach ($historibulanini as $d)
                            @php
                            $path = Storage::url('uploads/absensi/'.$d->foto_in);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="calendar"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success" style="width:70px">{{$d->jam_in}}</span>
                                        <span class="badge badge-danger" style="width:70px">{{$presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum'}}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach --}}
                            @foreach ($historibulanini as $d)
@php
$path = Storage::url('uploads/absensi/'.$d->foto_in);
@endphp
<li>
    <div class="item">
        <div class="icon-box bg-primary">
            <ion-icon name="calendar"></ion-icon>
        </div>
        <div class="in">
            <div>
                {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}
                <br>
                {{-- 🔹 Status Persetujuan --}}
                @if($d->accept == 1)
                    <span class="badge bg-success" style="margin-top: 4px; width: 80px;">Disetujui </span>
                @elseif($d->accept == 2)
                    <span class="badge bg-danger" style="margin-top: 4px; width: 80px;">Ditolak </span>
                @else
                    <span class="badge bg-warning" style="margin-top: 4px; width: 80px;">Menunggu </span>
                @endif
            </div>
            <span class="badge badge-success" style="width:70px">{{$d->jam_in}}</span>
            <span class="badge badge-danger" style="width:70px">{{$presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum'}}</span>
        </div>
    </div>
</li>
@endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ( $leaderboard as $d )
                             <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $d->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $d->sekolah }}</small>
                                        </div>
                                        <span class="badge {{ $d->jam_in < "08:00" ? "bg-success" : "bg-danger" }}" style="width:70px">
                                            {{ $d->jam_in }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                           
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    
@endsection