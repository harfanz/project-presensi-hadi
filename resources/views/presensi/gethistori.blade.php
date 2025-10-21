@if ($histori->isEmpty())
    <div class="alert alert-outline-warning">
        <p>Data Tidak Ada</p>
    </div>
@endif

@foreach ($histori as $d )
 <ul class="listview image-listview">
    <li>
         <div class="item">
            @php
            $path = Storage::url('uploads/absensi/'.$d->foto_in);
            @endphp
             <img src="{{ url($path) }}" alt="image" class="image">
           <div class="in">
              <div>
               <b>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</b><br>
            {{-- <small class="text-muted">{{ $d->seksi }}</small> --}}
              @if($d->accept == 1)
                    <span class="badge bg-success" style="margin-top: 4px; width: 80px;">Disetujui </span>
                @elseif($d->accept == 2)
                    <span class="badge bg-danger" style="margin-top: 4px; width: 80px;">Ditolak </span>
                @else
                    <span class="badge bg-warning" style="margin-top: 4px; width: 80px;">Menunggu </span>
                @endif
           </div>
              <span  class="badge {{ $d->jam_in < "08:00" ? "bg-success" : "bg-danger" }}" style="width:70px">{{ $d->jam_in }}</span>
              <span class="badge badge-danger" style="width:70px">{{$d->jam_in != null && $d->jam_out != null ? $d->jam_out : 'Belum'}}</span>
        </div>
        </div>
    </li>
 </ul>

@endforeach