@extends('layouts.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin TrackPKL</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<div class="container" style="margin-top:70px; padding-bottom:100px;">
    {{-- Alert --}}
    @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
    @endphp
    @if($messagesuccess)
        <div class="alert alert-success">
            {{ $messagesuccess }}
        </div>
    @endif
    @if($messageerror)
        <div class="alert alert-danger">
            {{ $messageerror }}
        </div>
    @endif

    {{-- List Izin --}}
    @foreach ($dataizin as $d)
    <ul class="listview image-listview mb-2">
        <li>
            <div class="item p-2" style="border:1px solid #ddd; border-radius:8px; background-color:#fff;">
                
                {{-- Info & Status --}}
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <b>{{ date("d-m-Y", strtotime($d->tgl_izin)) }} 
                        ({{ $d->status == "s" ? "Sakit" : "Izin" }})</b><br>
                        <small class="text-muted">{{ $d->keterangan }}</small>
                    </div>
                    <div style="margin-left: 35%; position: absolute;">
                        @if ($d->status_approved == 0)
                            <span class="badge bg-warning" style="width:90px;">Waiting</span>
                        @elseif($d->status_approved == 1)
                            <span class="badge bg-success" style="width:90px;">Approved</span>
                        @elseif($d->status_approved == 2)
                            <span class="badge bg-danger" style="width:90px;">Decline</span>
                        @endif
                    </div>
                </div>

                {{-- Kotak Balasan Admin --}}
                <div style="
                    padding:10px; 
                    border:1px solid #ccc; 
                    border-radius:6px; 
                    min-height:50px; 
                    background-color:#f9f9f9; 
                    width:40%; 
                    margin-left:auto;
                    word-wrap: break-word;
                ">
                    {{ $d->balasan }}
                </div>

            </div>
        </li>
    </ul>
    @endforeach
</div>

{{-- FAB Button --}}
<div class="fab-button" style="position: fixed; bottom: 20px; right: 20px; z-index:1000;">
    <a href="/presensi/buatizin" class="fab">
        <ion-icon name="add-circle-outline"></ion-icon>
    </a>
</div>

{{-- Optional CSS tambahan --}}
@push('myscript')
<style>
    body, html {
        height: 100%;
        overflow-y: auto;
        background-color: #f0f2f5;
    }

    .listview .item {
        display: block;
        background-color: #fff;
    }

    .fab {
        font-size: 40px;
        color: #0f3a7e;
    }
</style>
@endpush

@endsection
