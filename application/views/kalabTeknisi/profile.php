<!-- End of Topbar -->
<div class="scroll">

<?php
$queryLab = "select * from lab ";
$lab = $this->db->query($queryLab)->result_array();
        $lab = $this->db->query($queryLab)->result_array();
        $namaLab = [];
                    foreach ($lab as $l) {
                        $namaLab[$l['id']] = $l['nama'];
                    }
        $namaRole = [
            1=>'Admin',
            2=>'Dosen',
            3=>'Mahasiswa'
        ];
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h5 mb-3 text-gray-800 ml-5"><?= $title; ?></h1>

    <div class="row">
        <div class="col">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="row no-gutters">
        <!-- Kolom untuk kartu profil -->
        <div class="col-md-7 ml-5">
            <div class="card m-0 ">
                <div class="card-header">
                    <h3>PROFIL</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nama : <?= $user['name']; ?></li>
                    <li class="list-group-item">Nama : <?= $namaRole[$user['role_id']]; ?></li>
                    <li class="list-group-item">Level : <?= $namaLab[$user['level']]; ?></li>
                    
                </ul>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
</div>