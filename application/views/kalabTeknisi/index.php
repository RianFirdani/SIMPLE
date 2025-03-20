<?php
$tanggal_input = $this->input->post('tanggal');;
$tanggal_obj = new DateTime($tanggal_input);
$tanggal = $tanggal_obj->format('Y-m-d');
$hari = $tanggal_obj->format('d');
$bulan = $tanggal_obj->format('m');
$tahun = $tanggal_obj->format('Y');

$tanggal_input2 = $this->input->post('tanggal2');;
$tanggal_obj2 = new DateTime($tanggal_input2);
$tanggal2 = $tanggal_obj2->format('Y-m-d');
$hari2 = $tanggal_obj2->format('d');
$bulan2 = $tanggal_obj2->format('m');
$tahun2 = $tanggal_obj2->format('Y');

$bulanNama = [
    1  => 'Januari',
    2  => 'Februari',
    3  => 'Maret',
    4  => 'April',
    5  => 'Mei',
    6  => 'Juni',
    7  => 'Juli',
    8  => 'Agustus',
    9  => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
$Bulan = $bulanNama[intval($bulan)];
$Bulan2 = $bulanNama[intval($bulan2)];

// Query langsung untuk tanggal
$query_harian = $this->db->query("SELECT COUNT(*) AS jumlah_harian FROM pinjam WHERE tanggal_pinjam = '$tanggal2'")->row()->jumlah_harian;

// Query langsung untuk bulan
$query_bulanan = $this->db->query("SELECT COUNT(*) AS jumlah_bulanan FROM pinjam WHERE MONTH(tanggal_pinjam) = $bulan2 AND YEAR(tanggal_pinjam) = $tahun2")->row()->jumlah_bulanan;

// Query langsung untuk tahun
$query_tahunan = $this->db->query("SELECT COUNT(*) AS jumlah_tahunan FROM pinjam WHERE YEAR(tanggal_pinjam) = $tahun2")->row()->jumlah_tahunan;

// Query langsung untuk tanggal
$query_harian3 = $this->db->query("SELECT COUNT(*) AS jumlah_harian FROM pinjam WHERE tanggal_pinjam = '$tanggal' AND nama_lab ='$nama_lab'")->row()->jumlah_harian;

// Query langsung untuk bulan
$query_bulanan3 = $this->db->query("SELECT COUNT(*) AS jumlah_bulanan FROM pinjam WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun AND nama_lab = '$nama_lab' ")->row()->jumlah_bulanan;

// Query langsung untuk tahun
$query_tahunan3 = $this->db->query("SELECT COUNT(*) AS jumlah_tahunan FROM pinjam WHERE YEAR(tanggal_pinjam) = $tahun AND nama_lab = '$nama_lab' ")->row()->jumlah_tahunan;

$queryLab = "select * from lab where id > 2";
$lab = $this->db->query($queryLab)->result_array();
$namaLab = [];
foreach ($lab as $l) {
    $namaLab[$l['id']] = $l['nama'];
}
$queryDetailLab = "select * from lab where id = '$inputLab'";
$detailLab = $this->db->query($queryDetailLab)->result_array();
?>
<style>
    .form-group {
        display: flex;
        /* Gunakan Flexbox untuk meratakan elemen */
        align-items: center;
        /* Sejajarkan label dan input di tengah vertikal */
        justify-content: flex-start;
        /* Label tetap berada di kiri */
        margin-bottom: 15px;
        /* Spasi bawah antar form group */
    }

    .form-group label {
        width: 150px;
        /* Lebar tetap untuk label */
        text-align: left;
        /* Teks label rata kiri */
        margin-right: 10px;
        /* Jarak antara label dan input */
    }

    .form-group input {
        flex-grow: 1;
        /* Input akan mengambil sisa ruang */
        padding: 8px;
        box-sizing: border-box;
        /* Agar padding tidak menambah lebar input */
    }
</style>

<div class="container-fluid">
    <div class="container">
        <h1><?= $title . (($user['level'] != 1) ? $namaLab[$user['level']] : 'Super') ?></h1>
        <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#cari">
            Cari jadwal
        </button>

        <div class="row">
            <div class="ml-3 col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Peminjaman pada <?= $tanggal; ?> Lab : <?= $nama_lab ?> </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_harian3 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Peminjaman Bulan <?= $Bulan; ?> Lab : <?= $nama_lab ?> </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_bulanan3 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Peminjaman tahun <?= $tahun ?> Lab : <?= $nama_lab ?></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_tahunan3 ?> </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <table class="table table-bordered table-hover table-striped table-primary">
            <thead>
                <tr>
                    <th>Lab</th>
                    <th>Kalab</th>
                    <th>Teknisi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detailLab as $dl) : ?>
                    <tr>
                        <td><?= $dl['nama'] ?></td>
                        <td><?= $dl['kalab'] ?></td>
                        <td><?= $dl['teknisi'] ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <br>


        <?php if ($user['level'] == 1) : ?>
            <h1>Total Peminjaman Seluruh Lab</h1>
            <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#cariSemua">
                Cari jadwal
            </button>
            <br>
            <div class="row">
                <div class="ml-3 col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Peminjaman pada <?= $tanggal2; ?> </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_harian ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Peminjaman Bulan <?= $Bulan2; ?> </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_bulanan ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Peminjaman tahun <?= $tahun2 ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query_tahunan ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="modal fade" id="cari" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cariLabel">Mulai Cari</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('KalabTeknisi/index') ?>" method="post">
                            <div class="form-group">
                                <label for="tanggal">Cari Tanggal : </label>
                                <input type="date" name="tanggal" id="tanggal" style="max-width: fit-content;">
                            </div>
                            <div class="form-group">
                                <?php if ($user['level'] != 1) : ?>
                                    <input type="hidden" name="lab" value="<?= $user['level']; ?>">
                                <?php else : ?>
                                    <label for="lab">Pilih Lab : </label>
                                    <select name="lab" id="lab" style="width: 155px;">
                                        <option value="" selected>Pilih Lab</option>
                                        <?php foreach ($lab as $l) : ?>
                                            <option value="<?= $l['id'] ?>"><?= $l['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif ?>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cariSemua" tabindex="-1" aria-labelledby="cariSemuaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cariSemuaLabel">Mulai Cari</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('KalabTeknisi/index') ?>" method="post">
                            <div class="form-group">
                                <label for="tanggal">Cari Tanggal : </label>
                                <input type="date" name="tanggal2" id="tanggal2">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>