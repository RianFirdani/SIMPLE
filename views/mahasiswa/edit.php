
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?= $this->session->flashdata('message'); ?>
    <div class="row">
        <div class="col-lg-8">

            <?= form_open_multipart('mahasiswa/edit'); ?>
            <div class="form-group-row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" value="<?= $user['email']; ?>" id="email" placeholder="" name="email" readonly>
                </div>
            </div>    
            <div class="form-group-row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                <input type="text" value="<?= $user['name']; ?>" class="form-control" id="name" placeholder="" name="name" >
                <?=form_error('name','<small class="text-danger pl-3">','</small>');?>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="sm-10 mt-2">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
            </form>
        </div>
    </div>

                    
</div>
