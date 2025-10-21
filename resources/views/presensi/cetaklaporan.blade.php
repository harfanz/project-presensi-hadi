<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi PKL</title>

  <!-- Normalize CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Paper CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <style>
    @page { size: A4 }

    .tabledatauser, .tablepresensi {
      object-position: center;
    }

    #title {
      font-size: 18px;
      font-weight: bold;
      font-family: Arial, Helvetica, sans-serif;
    }

    .tabledatauser {
      margin-top: 40px
    }

    .tabledatauser td {
      padding: 2px;
      font-family: Arial, Helvetica, sans-serif;
    }

    .tablepresensi {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    .tablepresensi th {
      border: 1px solid black;
      padding: 8px;
      background-color: #d1d1d1;
      font-size: 14px;
    }

    .tablepresensi td {
      border: 1px solid black;
      padding: 8px;
      font-size: 12px;
    }

    .foto {
      width: 40px;
      height: 30px;
      object-fit: cover;
      object-position: center;
      border-radius: 3px;
      border: 1px solid #aaa;
      display: block;
      margin: auto;
    }
  </style>
</head>

<body class="A4">
  
  <?php
  // 🔹 Fungsi aman untuk menghitung selisih waktu
  if (!function_exists('selisih')) {
      function selisih($jam_masuk, $jam_keluar)
      {
          // Jika jam kosong/null
          if (empty($jam_masuk) || empty($jam_keluar)) {
              return "00:00:00";
          }

          // Pisahkan jam, menit, detik dengan aman
          $masuk = explode(":", $jam_masuk);
          $keluar = explode(":", $jam_keluar);

          $h1 = $masuk[0] ?? 0;
          $m1 = $masuk[1] ?? 0;
          $s1 = $masuk[2] ?? 0;

          $h2 = $keluar[0] ?? 0;
          $m2 = $keluar[1] ?? 0;
          $s2 = $keluar[2] ?? 0;

          // Hitung selisih waktu
          $dtAwal = mktime($h1, $m1, $s1, 1, 1, 1);
          $dtAkhir = mktime($h2, $m2, $s2, 1, 1, 1);
          $dtSelisih = $dtAkhir - $dtAwal;

          if ($dtSelisih < 0) {
              return "00:00:00"; // Antisipasi jam keluar lebih kecil
          }

          $totalmenit = $dtSelisih / 60;
          $jam = floor($totalmenit / 60);
          $menit = floor($totalmenit - ($jam * 60));
          $detik = $dtSelisih % 60;

          return sprintf("%02d:%02d:%02d", $jam, $menit, $detik);
      }
  }
  ?>

  <section class="sheet padding-10mm">
    <table style="width: 100%">
      <tr>
        <td style="width: 60px">
          <img src="{{ asset('assets/img/logopresensi.png') }}" width="90" height="90" alt="">
        </td>
        <td>
          <span id="title">
            LAPORAN PRESENSI PKL<br>
            PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
            PT. INDONESIA TORAY SYNTHETICS
          </span><br>
          <span style="line-height: 3px"><i>Moh. Toha Km 1 Tangerang, West Java Tel: +62 21 552-0643 Fax: +62 21 552-4909</i></span>
        </td>
      </tr>
    </table>

    <hr>

    <table class="tabledatauser">
      <tr>
        <td rowspan="6">
          @php
            $path = Storage::url('uploads/users/'.$user->foto);
          @endphp
          <img src="{{ url($path) }}" alt="Foto Pengguna"
          style="width:100px; height:150px; object-fit:cover; border-radius:8px; border:2px solid #ddd;">
        </td>
      </tr>
      <tr>
        <td>ID PKL</td>
        <td>:</td>
        <td>{{ $user->id_pkl }}</td>
      </tr>
      <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td>{{ $user->nama_lengkap }}</td>
      </tr>
      <tr>
        <td>Sekolah</td>
        <td>:</td>
        <td>{{ $user->sekolah }}</td>
      </tr>
      <tr>
        <td>Departemen</td>
        <td>:</td>
        <td>{{ $user->nama_dept }}</td>
      </tr>
      <tr>
        <td>No. Hp</td>
        <td>:</td>
        <td>{{ $user->no_hp }}</td>
      </tr>
    </table>

    <table class="tablepresensi">
      <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Foto Masuk</th>
        <th>Jam Pulang</th>
        <th>Foto Pulang</th>
        <th>Keterangan</th>
        <th>Jam Kerja</th>
      </tr>

      @foreach ($presensi as $d)
        @php
          $path_in = $d->foto_in ? Storage::url('uploads/absensi/'.$d->foto_in) : null;
          $path_out = $d->foto_out ? Storage::url('uploads/absensi/'.$d->foto_out) : null;

          $jamterlambat = selisih('08:00:00', $d->jam_in);
        @endphp

        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
          <td>
          @if (!empty($d->status))
        @if (strtolower($d->status) == 'i')
            Izin
        @elseif (strtolower($d->status) == 's')
            Sakit
        @else
            {{ $d->jam_in ?? '-' }}
        @endif
    @else
        {{ $d->jam_in ?? '-' }}
    @endif
          </td>
          <td>
            @if ($path_in)
              <img src="{{ url($path_in) }}" class="foto" alt="">
            @else
              <img src="{{ asset('assets/img/camera.jpg') }}" class="foto" alt="">
            @endif
          </td>

          <td>{{ $d->jam_out ?? 'Belum Absen' }}</td>
          <td>
            @if ($path_out)
              <img src="{{ url($path_out) }}" class="foto" alt="">
            @else
              <img src="{{ asset('assets/img/camera.jpg') }}" class="foto" alt="">
            @endif
          </td>

          <td>
            @if (!empty($d->keterangan))
              {{ ucfirst($d->keterangan) }}
            @elseif (!empty($d->jam_in) && $d->jam_in > '08:00:00')
              Terlambat {{ $jamterlambat }}
            @elseif (!empty($d->jam_in))
              Tepat Waktu
            @else
              -
            @endif
          </td>

          <td>
            @if (!empty($d->jam_in) && !empty($d->jam_out))
              {{ selisih($d->jam_in, $d->jam_out) }}
            @else
              00:00:00
            @endif
          </td>
        </tr>
      @endforeach

    </table>
  </section>

</body>
</html>
