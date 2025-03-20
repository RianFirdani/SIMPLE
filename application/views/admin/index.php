                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <style>
                        .form-group {
                            display: flex;
                            align-items: center;
                            /* Align input and label vertically */
                            justify-content: flex-start;
                            /* Align items horizontally */
                            margin-bottom: 15px;
                            /* Space between form fields */
                        }

                        .form-group label {
                            width: 150px;
                            /* Fixed width for label to align properly */
                            margin-right: 10px;
                            /* Space between label and input */
                            text-align: right;
                            /* Align label text to the right */
                        }

                        .form-group input,
                        .form-group select {
                            width: calc(100% - 160px);
                            /* Adjust the width to take remaining space */
                            padding: 5px;
                            box-sizing: border-box;
                            /* Ensure padding doesn't affect width */
                        }

                        .form-group small.text-danger {
                            margin-left: 160px;
                            /* Align the error message under the input field */
                        }
                    </style>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
                    <div class="row">
                        <div class="col-lg-8">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <?php

                    $lab = $this->db->query('select * from lab')->result_array();
                    $namaRole = [
                        '1' => 'Admin',
                        '2' => 'Kalab / Teknisi'
                        
                    ];

                    $queryUser = "Select * FROM user";
                    $user = $this->db->query($queryUser)->result_array();
                    $roleUser = $this->db->query('select * from user_role where id<3')->result_array();
                    $queryRole = "SELECT user.id, user.name, role.role_name
                                FROM user
                                JOIN role ON user.role_id = role.id";
                    $queryLab = "Select * from lab where id >2";

                    $namaLab = [];
                    foreach ($lab as $l) {
                        $namaLab[$l['id']] = $l['nama']; // Simpan id lab sebagai key dan nama lab sebagai value
                    }
                    ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        Tambah User
                    </button>
                    <table id="kontol" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Nip</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($user as $u) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $u['name']; ?></td>
                                    <td><?= $u['nip']; ?></td>
                                    <td><?= $u['email']; ?></td>
                                    <td><?= $namaRole[$u['role_id']] ?></td>
                                    <?php if ($namaRole[$u['role_id']] != 1 && $namaRole[$u['role_id']] != 2) : ?>
                                        <td><?= $namaLab[$u['level']] ?></td>
                                    <?php else :  ?>
                                        <td>Super</td>
                                    <?php endif; ?>
                                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal<?= $u['id']; ?>"><i class="fas fa-fw fa-edit"></i></button>
                                        <div class="modal fade" id="editModal<?= $u['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Role</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('admin/editRole') ?>" method="post">
                                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                            <div class="form-group">
                                                                <label for="nama">Nama : </label>
                                                                <input type="text" placeholder="<?= $u['name'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nip">NIP : </label>
                                                                <input type="text" name="nip" id="nip" value="<?= $u['nip'] ?>">
                                                                <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role">Pilih Role : </label>
                                                                <select name="role" id="role">
                                                                    <?php foreach ($roleUser as $r) :  ?>
                                                                        <option value="<?= $r['id'] ?>" <?= $u['role_id'] == $r['id'] ? 'selected' : '' ?>><?= $r['role'] ?> </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="level">Pilih Level : </label>
                                                                <select name="level" id="level">
                                                                    <?php foreach ($lab as $p) :  ?>
                                                                        <option value="<?= $p['id'] ?>" <?php if ($namaLab[$u['level']] == $p['nama']) echo 'selected' ?>><?= $p['nama'] ?></option>
                                                                    <?php endforeach;  ?>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal<?= $u['id']; ?>"><i class="fas fa-fw fa-trash"></i></button>
                                        <div class="modal fade" id="hapusModal<?= $u['id']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusModalLabel">Hapus User</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('admin/hapusUser') ?>" method="post">
                                                            <input type="hidden" name="idHapusUser" value="<?= $u['id']; ?>">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                                </tr>
                        </tbody>

                    </table>
                </div>
                <!-- Modal Edit -->
                <!-- Modal -->
                <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('admin/registrationAdmin') ?>" method="post">
                                    <div class="form-group">
                                        <label for="name">Nama : </label>
                                        <input type="text" name="name" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email : </label>
                                        <input type="email" name="email" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="nip">NIP : </label>
                                        <input type="text" name="nip" id="nip">
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">Password : </label>
                                        <input type="password" name="pass" id="pass">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Pilih Role : </label>
                                        <select name="role" id="role">
                                            <option value="" selected>Pilih Role</option>
                                            <?php foreach ($roleUser as $ru) : ?>
                                                <option value="<?= $ru['id'] ?>"><?= $ru['role'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Level">Level : </label>
                                        <select name="level" id="level">
                                            <option value="" selected>Pilih Level</option>
                                            <?php foreach ($lab as $la) : ?>
                                                <option value="<?= $la['id'] ?>"><?= $la['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
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



                <!-- End of Main Content -->