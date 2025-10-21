@extends('layouts.admin.tabler')
@section('content')


<div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Izin/Sakit
                    </h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <form action="/presensi/izinsakit" method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                                </span>
                                <input type="text" value="{{ request('dari') }}" class="form-control" id="dari" name="dari" placeholder="Dari">
                            </div>        
                        </div>
                        <div class="col-6">
                            <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>
                                </span>
                                <input type="text" value="{{ request('sampai') }}" class="form-control" id="sampai" name="sampai" placeholder="Sampai">
                            </div>        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                             <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 12l14 0" /></svg>
                                </span>
                                <input type="text" value="{{ request('id_pkl') }}" class="form-control" id="id_pkl" name="id_pkl" placeholder="Id PKL">
                            </div>   
                        </div>
                        <div class="col-3">
                             <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                </span>
                                <input type="text" value="{{ request('nama_lengkap') }}" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama User">
                            </div>   
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <select name="status_approved" id="status_approved" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="1" {{ request('status_approved') == 1 ? 'selected' : ''}}>Disetujui</option>
                                    <option value="2" {{ request('status_approved') == 2 ? 'selected' : ''}}>Ditolak</option>
                                    <option value="0" {{ request('status_approved') == '0' ? 'selected' : ''}}>Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="from-group">
                                <button class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>ID PKL</th>
                            <th>Nama Users</th>
                            <th>Sekolah</th>
                            <th>Alasan</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $d )
                             @php
                            $path = Storage::url('uploads/tandabukti/'.$d->tanda_bukti);
                            @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td> 
                            <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td> 
                            <td>{{ $d->id_pkl }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ $d->sekolah }}</td>
                            <td>{{ $d->status == 'i' ? 'Izin' : 'Sakit'}}</td>
                            <td>{{ $d->keterangan}}</td>
                            <td>
                                @if($d->tanda_bukti)
                                 <img src="{{ url($path) }}" 
                                alt="Bukti Izin"> 

                                @else
                                 <p>Tidak ada bukti</p>
                                @endif
                            </td>
                            <td>
                                @if ($d->status_approved == 1)
                                <span class="badge bg-success">Disetujui</span>
                                @elseif($d->status_approved == 2)
                                <span class="badge bg-danger">Ditolak</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            
                            <td>
                                @if ($d->status_approved == 0)
                                <a href="#" class="btn btn-sm btn-primary approve"   id_izinsakit="{{ $d->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                </a>
                                @else
                                <a href="/presensi/{{ $d->id }}/batalkanizinsakit" class="btn btn-sm btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M18.364 5.636l-12.728 12.728" /></svg>
                                    
                                </a>
                                @endif
                                
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
               {{ $izinsakit->links('pagination::bootstrap-5') }}
            </div>
        </div>
        
    </div>
    </div>
</div>
<div class="modal fade" id="modal-izinsakit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Izin/Sakit</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
        <!-- Isi peta akan dimuat di sini lewat AJAX -->
        <form action="/presensi/approveizinsakit" method="POST">
            @csrf
            <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
            <div class="row">
                <div class="col-12">
                    <div class="form-goup">
                        <select name="status_approved" id="status_approved" class="form-select">
                            <option value="1">Setujui</option>
                            <option value="2">Tolak</option>
                        </select>
                    </div>
                </div>
            </div>
           <div class="row mt-2">
                <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-message"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                                </span>
                                <input type="text" value="" class="form-control" id="balasan" name="balasan" placeholder="Pesan">
                    </div>        
                </div>
            </div>
            <div class="row mt-1" >
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $('.approve').click(function(e) {
            e.preventDefault();
            var id_izinsakit= $(this).attr("id_izinsakit");
            $("#id_izinsakit_form").val(id_izinsakit);
            $("#modal-izinsakit").modal("show");
        });

        $("#dari, #sampai").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
        format:'yyyy-mm-dd'
  });
    });
</script>
@endpush