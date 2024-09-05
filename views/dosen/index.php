                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg-8">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                <form action="<?= base_url('Dosen/pinjam') ?>" method="post">
                    <div class="container">
                    
                        <div class="form-group">
                            <input type="text" class="form-control"  name="peminjam" id="peminjam" placeholder="Masukkan Nama Peminjam">  
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  name="penginput" id="penginput" value="<?= $user['email']; ?>" readonly>  
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control"  name="tanggal" id="tanggal">  
                        </div>
                        <h6>Jam Mulai :</h6>
                        <div class="form-group">
                            <input type="time" name="mulai" id="mulai">
                        </div>
                        <h6>Jam Selesai :</h6>
                        <div class="form-group">
                            <input type="time" name="selesai" id="selesai">
                        </div>
                        <select name="lab" id="lab">
                        <?php
                            $queryLab = "Select * FROM lab";
                            $lab = $this->db->query($queryLab)->result_array();
                        ?>
                        <option value="">Pilih Lab</option>
                            <?php foreach($lab as $m) :?>
                                    <Option value="<?= $m['nama']; ?>"><?= $m['nama']; ?></Option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <br>
                        <button class="btn btn-primary" type="submit">Selesai</button>

                    </div>


                </form>

            </div>
            <!-- End of Main Content -->
