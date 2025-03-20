<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop Surat Poliban</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            margin: 20px 0;
        }

        .kop-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 20px 0;
            border-bottom: 2px solid black;
        }

        .kop-header img {
            width: 150px; /* Atau nilai yang lebih besar sesuai kebutuhan */
            height: 150px;
        }

        .kop-header .text {
            flex: 2;
        }

        .kop-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .kop-header h2 {
            margin: 0;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .kop-header p {
            margin: 5px 0;
            font-size: 20px;
        }

        .table-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
        }

        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
        }

        .simple-info {
            text-align: center;
            margin: 20px 0;
        }

        .simple-info h2 {
            margin: 5px 0;
        }
    </style>
    <script>
        function printAndRedirect() {
            // Membuka dialog cetak
            window.print();
            
            // Setelah dialog cetak ditutup, redirect ke halaman index
            window.onafterprint = function() {
                window.location.href = '<?= base_url('kalabTeknisi/jadwal'); ?>'; // Ganti URL sesuai dengan rute ke halaman index
            };
        }
    </script>
</head>
<body onload="printAndRedirect()">
    <?php
    $lab = $this->input->post('lab');
    $tanggal_input = $this->input->post('tanggal');;
    $tanggal_input = $this->input->post('tanggal');;
    $tanggal_obj = new DateTime($tanggal_input);
    $tanggal = $tanggal_obj->format('Y-m');
    $bulan = $tanggal_obj->format('m');
    $tahun = $tanggal_obj->format('Y');
    $query = $this->db->query("SELECT * FROM pinjam WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun AND nama_lab = '$lab'");
    $print = $query->result_array();
    ?>
    
    <form action="<?= base_url('kalabTeknisi/cetak') ?>" method="post">
    <div class="kop-surat">
        <div class="kop-header">
            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo Poliban" width="150px" height="150px">
            <div class="text">
                <h1>Politeknik Negeri Banjarmasin</h1>
                <h2>POLIBAN</h2>
                <p>Jl. Hasan Basri, Banjarmasin, Kalimantan Selatan</p>
                <p>Telp. (0511) 1234567 &nbsp; | &nbsp; Web: www.poliban.ac.id</p>
            </div>
        </div>
    </div>

    <!-- Tabel Data Absen -->
    <table class="table table-bordered table-hover table-striped" >
    <thead>
        <tr>
        <th>No.</th>
        <th>penginput</th>
        <th>Mata Kuliah</th>
        <th>Dosen Pengajar</th>
        <th>Kelas</th>
        <th>Nama Wakil Mahasiswa</th>
        <th>Hari & Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Teori/Praktek</th>
        <th>Nama Lab</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php foreach($print as $p) : ?>
        <tr>
            <td><?= $i++?></td>
            <td><?=$p['penginput']?></td>
            <td><?= $p['matkul']; ?></td>
            <td><?=$p['dosen_pengajar'];?></td>
            <td><?=$p['kelas'];?></td>
            <td><?=$p['wakil_mhs'];?></td>
            <td><?=$p['tanggal_pinjam'];?></td>
            <td><?=$p['jam'];?></td>
            <td><?=$p['selesai'];?></td>
            <td><?=$p['Teori/Praktek'];?></td>
            <td><?=$p['nama_lab'];?></td>
            <td>
            <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </form>
</body>
</html>