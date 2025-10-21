<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <style>
    @page { size: A4 landscape; margin: 10mm; }

    body.A4.landscape {
      zoom: 90%;
    }

    .tabledatauser, .tablepresensi {
      object-position: center;
    }

    #title {
      font-size: 18px;
      font-weight: bold;
      font-family: Arial, Helvetica, sans-serif;
    }

    .tabledatauser {
      margin-top: 40px;
    }

    .tabledatauser td {
      padding: 2px;
    }

    .tablepresensi {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      table-layout: fixed;
      font-size: 9px;
      word-wrap: break-word;
    }

    .tablepresensi th,
    .tablepresensi td {
      border: 1px solid black;
      padding: 3px;
      text-align: center;
      vertical-align: middle;
    }

    .tablepresensi th {
      background-color: #d1d1d1;
      font-size: 9px;
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

    @media print {
      body {
        zoom: 85%;
      }
    }
  </style>

</head>

<body class="A4 landscape">
  <?php
  if (!function_exists('selisih')) {
      function selisih($jam_masuk, $jam_keluar) {
          list($h, $m, $s) = explode(":", $jam_masuk);
          $dtAwal = mktime($h, $m, $s, "1", "1", "1");
          list($h, $m, $s) = explode(":", $jam_keluar);
          $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
          $dtSelisih = $dtAkhir - $dtAwal;

          $totalmenit = $dtSelisih / 60;
          $jam = floor($totalmenit / 60);
          $menit = floor($totalmenit - ($jam * 60));

          return sprintf("%02d:%02d", $jam, $menit); // tanpa detik
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
            REKAP PRESENSI PKL<br>
            PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
            PT. INDONESIA TORAY SYNTHETICS
          </span><br>
          <span style="line-height: 3px"><i>Moh. Toha Km 1 Tangerang, West Java Tel: +62 21 552-0643 Fax: +62 21 552-4909</i></span>
        </td>
      </tr>
    </table>
    <hr>

    <table class="tablepresensi">
      <tr>
        <th rowspan="2">ID PKL</th>
        <th rowspan="2">User</th>
        <th colspan="31">Tanggal</th>
        <th rowspan="2">TH</th>
        <th rowspan="2">Late</th>
      </tr>
      <tr>
        <?php for($i=1;$i<=31;$i++){ ?>
          <th>{{ $i }}</th>
        <?php } ?>
      </tr>

      @foreach ($rekap as $d)
      <tr>
        <td>{{ $d->id_pkl }}</td>
        <td>{{ $d->nama_lengkap }}</td>

        <?php
        $totalhadir = 0;
        $totalterlambat = 0;

        for($i=1;$i<=31;$i++){
    $tgl = 'tgl_'.$i;
    $tanggalSekarang = date("Y-m-d", strtotime("$tahun-$bulan-$i"));
    $izinSiswa = $izin->where('id_pkl', $d->id_pkl)->where('tgl_izin', $tanggalSekarang)->first();
?>
<td>
  @if($izinSiswa)
      <strong style="color:blue">{{ strtoupper($izinSiswa->status) }}</strong>
  @else
      @if(!empty($d->$tgl))
          <?php
              $hadir = explode("-", $d->$tgl);
          ?>
          @if(!empty($hadir[0]))
              <span style="color:{{ $hadir[0] > '08:00' ? 'red' : '' }}">
                  {{ date('H:i', strtotime($hadir[0])) }}
              </span><br>
          @endif

          @if(!empty($hadir[1]))
              <span style="color:{{ $hadir[1] < '17:00' ? 'red' : '' }}">
                  {{ date('H:i', strtotime($hadir[1])) }}
              </span>
          @endif
      @endif
  @endif
</td>
<?php } ?>


        <td>{{ $totalhadir }}</td>
        <td>{{ $totalterlambat }}</td>
      </tr>
      @endforeach
    </table>

  
  </section>
</body>
</html>