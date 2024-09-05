                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg-8">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>

    <?php
    $queryPinjam = "Select * FROM pinjam";
    $pinjam = $this->db->query($queryPinjam)->result_array();
    ?>
    <?php
        $queryLab = "Select * FROM lab";
        $lab = $this->db->query($queryLab)->result_array();
    ?>
    
<table id="kontol" class="table table-bordered table-hover table-striped" >
    <thead>
        <tr>
        <th>No.</th>
        <th>Peminjam</th>
        <th>Penginput</th>
        <th>Tanggal Pinjam</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>nama_lab</th>
        <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php foreach($pinjam as $p) : ?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $p['peminjam']; ?></td>
            <td><?=$p['penginput']?></td>
            <td><?=$p['tanggal_pinjam']?></td>
            <td><?=$p['jam']?></td>
            <td><?=$p['selesai']?></td>
            <td><?=$p['nama_lab']?></td>
            <td>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal<?= $p['id'] ?>"><i class="fas fa-fw fa-edit"></i></button>
            <div class="modal fade" id="editModal<?=$p['id']?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Edit Jadwal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('dosen/editPinjam') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <div class="form-group">
                                    <label for="peminjam">Nama Peminjam : </label>
                                    <input type="text" name="peminjam" value="<?= $p['peminjam'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penginput">Nama Penginput : </label>
                                    <input type="text" name="penginput" value="<?= $p['penginput'] ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Pinjam : </label>
                                    <input type="date" name="tanggal" value="<?= $p['tanggal_pinjam'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mulai">Jam Mulai : </label>
                                    <input type="time" name="mulai" value="<?= $p['jam'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="selesai">Jam Selesai : </label>
                                    <input type="time" name="selesai" value="<?= $p['selesai'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Pilih Lab : </label>
                                <select name="lab" id="lab">
                                    <?php foreach($lab as $l) : ?>
                                        <option value="<?= $l['nama'] ?>"><?= $l['nama'] ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit"class="btn btn-success">Edit</button>      
                        </div>
                            </form>
                        </div>
                        
                        </div>
                    </div>
                    </div>
            
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal<?=$p['id']?>"><i class="fas fa-fw fa-trash"></i></button>
            <div class="modal fade" id="hapusModal<?=$p['id']?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="hapusModalLabel">Hapus Jadwal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('dosen/hapusPinjam') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit"class="btn btn-danger">Hapus</button>      
                        </div>
                            </form>
                        </div>
                        
                        </div>
                    </div>
                    </div>
            </td>
            
        </tr>
        <?php endforeach;  ?>
    </tbody>
</table>
                    
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
