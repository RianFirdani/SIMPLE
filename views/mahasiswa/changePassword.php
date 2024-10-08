<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    
    <div class="row">
    
        <div class="col-lg-6">
        <?= $this->session->flashdata('message'); ?>
            <form action="<?= base_url('mahasiswa/changePassword'); ?>" method="post">
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" class="form-control" name="currentPassword" id="">
                    <?=form_error('currentPassword','<small class="text-danger pl-3">','</small>');?>
                </div>

                <div class="form-group">
                    <label for="newPassword1">New Password</label>
                    <input type="password" class="form-control" name="newPassword1" id="newPassword1">
                    <?=form_error('newPassword1','<small class="text-danger pl-3">','</small>');?>
                </div>

                <div class="form-group">
                    <label for="newPassword2">Repeat Password</label>
                    <input type="password" class="form-control" name="newPassword2" id="newPassword2">
                    <?=form_error('newPassword2','<small class="text-danger pl-3">','</small>');?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>



            </form>
        </div>
    </div>
                    
</div>

