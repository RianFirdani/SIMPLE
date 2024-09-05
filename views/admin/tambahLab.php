<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
              <?= $this->session->flashdata('message'); ?>
           </div>
     </div>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
  Tambahkan Lab
</button>
    
    <div class="row">

    <?php 
        $lab = $this->db->query('select * from lab')->result_array();
        $i = 1;
        $u = 5;  
    ?>

    
        <div class="col-lg-6">
        <table id="kontol" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lab</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($lab as $l) : ?>
                <tr>
                
                    <td><?= $i++; ?></td>
                    <td><?= $l['nama'] ?></td>
                    <td>                 
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $l['id'] ?>"><i class="fas fa-fw fa-edit"></i></button>
                      <div class="modal fade" id="editModal<?= $l['id'] ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Lab</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="<?= base_url('Admin/editLab') ?>" method="post">
                              <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="idEdit" value="<?= $l['id']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="TambahLab">Nama Lab : </label>
                                        <input type="text" name="namLab" id="namLab" value="<?= $l['nama'] ?>">
                                    </div>
                                    <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Ubah data</button>
                              </div>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>  
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $l['id'] ?>"><i class="fas fa-fw fa-trash"></i></button>  
                      <!-- Modal Hapus Lab -->
                      <div class="modal fade" id="hapusModal<?= $l['id'] ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="hapusModalLabel">Tambahkan Lab Baru</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('Admin/hapusLab') ?>" method="post">
                            <div class="modal-body">
                                  <div class="form-group">
                                      <input type="hidden" name="idHapus" value="<?= $l['id']; ?>">
                                  </div>
                                  <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-danger">Hapus data</button>
                            </div>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                    
</div>
<!-- Modal Tambah LAb -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tambahModalLabel">Tambahkan Lab Baru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('Admin/TambahLab') ?>" method="post">
      <div class="modal-body">
            <div class="form-group">
                <label for="TambahLab">Tambahkan Lab : </label>
                <input type="text" name="TambahLab" id="TambahLab">
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah data</button>
      </div>
      </div>
      </form>
    </div>
  </div>
</div>



