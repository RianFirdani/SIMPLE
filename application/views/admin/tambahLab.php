<div class="container-fluid">
  <Style>
    .container {
      max-width: 800px;
      /* Batasi lebar container */
      margin: 0 auto;
      /* Pusatkan container */
    }

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

    /* Responsive untuk layar kecil */
    @media (max-width: 768px) {
      .form-group {
        flex-direction: column;
        align-items: flex-start;
      }

      .form-group label {
        width: 100%;
        text-align: left;
        margin-bottom: 5px;
      }
      
    }
  </style>
  <?php
    $lab = $this->db->query('select * from lab where id > 2')->result_array();
    $i = 1;
    $u = 5;
    $queryDosen = "select * from user where role_id = 2 order by name asc";
    $queryUSer = "select * from user where role_id = 2";
    $user = $this->db->query($queryUSer)->result_array();
    $dosen = $this->db->query($queryDosen)->result_array();
    ?>

  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <div class="col-lg-8">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
    Tambahkan Lab
  </button>
<br>
<br>
  <div class="row">
    <div class="col-lg-6">
      <table id="tabel" class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Lab</th>
            <th>Kepala Lab</th>
            <th>Teknisi Lab</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>


          <?php foreach ($lab as $l) : ?>
            <tr>

              <td><?= $i++; ?></td>
              <td><?= $l['nama'] ?></td>
              <td><?= $l['kalab'] ?></td>
              <td><?= $l['teknisi'] ?></td>
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
                          <div class="form-group">
                            <label for="TambahLab">Kepala Lab : </label>
                            <select name="kalab" id="kalab" style="width: 300px;">
                              <?php foreach ($dosen as $d) : ?>
                                <option value="<?= $d['id'] ?>" <?php if ($d['name'] == $l['kalab']) echo 'selected' ?>><?= $d['name'] ?> (<?= $d['nip'] ?>)</option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="TambahLab">Teknisi : </label>
                            <select name="teknisi" id="teknisi" style="width: 300px;">
                              <?php foreach ($dosen as $d) : ?>
                                <option value="<?= $d['id'] ?>" <?php if ($d['name'] == $l['teknisi']) echo 'selected' ?>><?= $d['name'] ?> (<?= $d['nip'] ?>)</option>
                              <?php endforeach; ?> 
                            </select>
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
                        <h1 class="modal-title fs-5" id="hapusModalLabel">Hapus Lab</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="<?= base_url('Admin/hapusLab') ?>" method="post">
                        <div class="modal-body">
                          Anda yakin ingin menghapus lab ini??
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
            <div class="form-group">
              <label for="TambahLab">Kepala Lab : </label>
              <select name="kalab" id="kalab" style="width: 300px;">
                <option value="" selected>Pilih Kepala Lab</option>
                <?php foreach ($dosen as $d) : ?>
                  <option value="<?= $d['id'] ?>"><?= $d['name'] ?> (<?= $d['nip'] ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="TambahLab">Teknisi : </label>
              <select name="teknisi" id="teknisi" style="width: 300px;">
                <option value="" selected>Pilih Teknisi</option>
                <?php foreach ($dosen as $d) : ?>
                  <option value="<?= $d['id'] ?>"><?= $d['name'] ?> (<?= $d['nip'] ?>)</option>
                <?php endforeach; ?>
              </select>
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