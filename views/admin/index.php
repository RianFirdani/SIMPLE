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
                        $queryUser = "Select * FROM user";
                        $user = $this->db->query($queryUser)->result_array();
                        $roleUser = $this->db->query('select * from user_role')->result_array();
                    ?>
    <table id="kontol" class="table table-bordered table-hover table-striped" >
    <thead>
        <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Nip</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php foreach($user as $u) : ?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $u['name']; ?></td>
            <td><?= $u['nip']; ?></td>
            <td><?= $u['email']; ?></td>
            <?php if($u['role_id'] == 1): ?>
                <td>Admin</td>
            <?php elseif($u['role_id']==2): ?>
                <td>Dosen</td>
            <?php else :?>
                <td>Mahasiswa</td>
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
                                    <label for="nip">NIP : </label>
                                    <input type="text" name="nip" id="nip" value="<?= $u['nip'] ?>">
                                    <?=form_error('nip','<small class="text-danger pl-3">','</small>');?>
                                </div>
                                <div class="form-group">
                                    <label for="role">Pilih Role : </label>
                                    <select name="role" id="role">
                                        <?php foreach ($role as $p) :?>
                                            <option value="<?= $p['id']?>"><?= $p['role']?></option>
                                        <?php endforeach;?>
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
                <a onclick="confirmAction(event)" href="<?= base_url('Admin/hapusUser/').$u['id'] ?>" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
            </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
    
</table>
</div>
<!-- Modal Edit -->



            <!-- End of Main Content -->
