@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data PKL
                    </h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                         
                            @if(Session::get('success'))
                            <div class="alert alert-success">
                               {{ Session::get('success') }}
                        </div>
                        @endif
                        @if(Session::get('warning'))
                            <div class="alert alert-warning">
                               {{ Session::get('warning') }}
                        </div>
                        @endif
                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary" id="btnTambahUser">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Tambah Data</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="/user" method="GET">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Nama Siswa" value="{{ Request('nama_siswa') }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                        <option value="">Departemen</option>
                                        @foreach ($departemen as $d)
                                        <option {{ Request('kode_dept')==$d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                    </div>
                    <div class="row mt-2" >
                        <div class="col-12">
                            <table class="table table-bordered">
                <thead>
                    <th>No</th>
                    <th>Id PKL</th>
                    <th>Nama</th>
                    <th>Sekolah</th>
                    <th>No. Hp</th>
                    <th>Foto</th>
                    <th>Departemen</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($user as $d )
                    @php
                    $path = Storage::url('uploads/users/'.$d->foto);
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration + $user->firstItem() -1}}</td>
                            <td>{{ $d->id_pkl }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ $d->sekolah }}</td>
                            <td>{{ $d->no_hp }}</td>
                            <td>
                                @if (empty($d->foto))
                                <img src="{{ asset('assets/img/nophoto.jpg') }}" class="avatar" alt="">
                                @else
                                 <img src="{{ url($path) }}" class="avatar" alt="">
                                @endif
                               
                            </td>
                            <td>{{ $d->nama_dept }}</td>
                            <td>
                                <div class="btn-group">
                                   <a href="#" class="edit btn btn-info" id_pkl="{{ $d->id_pkl }}" >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                </a>
                                
                                <form action="/user/{{ $d->id_pkl }}/delete" method="POST" style="margin-left:5px">
                                    @csrf
                                 
                                    <a class="btn btn-danger delete-confirm">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    </a>

                                </form>
                                </div>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                        </div>
                    </div>
                    
            {{ $user->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
 <div class="modal modal-blur fade" id="modal-inputuser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <form action="/user/store" method="POST"  id="frmuser" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 12l14 0" /></svg>
                                </span>
                                <input type="text" value="" class="form-control" id="id_pkl" name="id_pkl" placeholder="Id PKL">
                    </div>        
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-question"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" /><path d="M19 22v.01" /><path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" /></svg>
                                </span>
                                <input type="text" value="" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap">
                    </div>        
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /></svg>
                                </span>
                                <input type="text" value="" class="form-control" id="sekolah" name="sekolah" placeholder="Sekolah">
                    </div>        
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <input type="text" value="" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP">
                    </div>        
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                   
                    <input type="file" name="foto" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <select name="kode_dept" id="kode_dept" class="form-select">
                                        <option value="">Departemen</option>
                                        @foreach ($departemen as $d)
                                        <option {{ Request('kode_dept')==$d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                        
                                        @endforeach
                                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11v6" /><path d="M9.5 13.5l2.5 -2.5l2.5 2.5" /></svg>
                            Simpan</button>
                    </div>
                </div>
            </div>
           </form>
          </div>
        </div>
      </div>
    </div>
    {{-- //modaledit --}}
    <div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadeditform">
           
          </div>
        </div>
      </div>
    </div>
@endsection


@push('myscript')
<script>
    
    $(function(){
        $("#btnTambahUser").click(function(){
            $("#modal-inputuser").modal("show");
        });

         $(".edit").click(function(){
            var id_pkl = $(this).attr('id_pkl');
            $.ajax({
                type: 'POST'
                , url: '/user/edit'
                , cache: false
                , data: {
                    _token:"{{  csrf_token() }}"
                    , id_pkl: id_pkl
                }
                , success: function(respond){
                    $("#loadeditform").html(respond);
                }
            })
            $("#modal-edituser").modal("show");
        });

        $(".delete-confirm").click(function(e){
            e.preventDefault();
            var form = $(this).closest('form');
       Swal.fire({
  title: "Apakah Anda yakin ingin menghapus data ini?",
  text: "Jika Iya maka data akan terhapus permanen",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: "Deleted!",
      text: "Data berhasi di Hapus",
      icon: "success"
 
    });
        form.submit();
  }
});

        });

        $('#frmuser').submit(function(){
            var id_pkl = $("#id_pkl").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var sekolah = $("#sekolah").val();
            var no_hp = $("#no_hp").val();
            var kode_dept = $("#frmuser").find("#kode_dept").val();

            if(id_pkl==""){
                     Swal.fire({
                     title: 'Warning!',
                      text: 'Id PKl Harus Diisi',
                      icon: 'warning',
                     confirmButtonText: 'Ok'
                    }).then((result)=>{
                    $("#id_pkl").focus();
                })
                return false;  
            }else if(nama_lengkap==""){
                     Swal.fire({
                     title: 'Warning!',
                      text: 'Nama Lengkap Harus Diisi',
                      icon: 'warning',
                     confirmButtonText: 'Ok'
                    }).then((result)=>{
                    $("#nama_lengkap").focus();
                })
                return false; 
            } else if(sekolah==""){
                     Swal.fire({
                     title: 'Warning!',
                      text: 'Sekolah Harus Diisi',
                      icon: 'warning',
                     confirmButtonText: 'Ok'
                    }).then((result)=>{
                    $("#sekolah").focus();
                })
                return false; 
            }else if(no_hp==""){
                     Swal.fire({
                     title: 'Warning!',
                      text: 'No. HP Harus Diisi',
                      icon: 'warning',
                     confirmButtonText: 'Ok'
                    }).then((result)=>{
                    $("#no_hp").focus();
                })
                return false; 
            }else if(kode_dept==""){
                     Swal.fire({
                     title: 'Warning!',
                      text: 'Kode Departemen Harus Diisi',
                      icon: 'warning',
                     confirmButtonText: 'Ok'
                    }).then((result)=>{
                    $("#kode_dept").focus();
                })
                return false; 
            } 
        });
    });
    </script>
@endpush