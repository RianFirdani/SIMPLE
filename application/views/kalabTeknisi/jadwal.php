                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <style>
                        /* Mengatur border hitam pada radio button */
                        .radioTeori {
                            border: 2px solid black;
                            /* Memberikan border hitam pada radio button */
                            /* Menghilangkan style default browser pada radio button */
                            width: 20px;
                            /* Menyesuaikan ukuran radio button */
                            height: 20px;
                            border-radius: 50%;
                            /* Membuat bentuknya tetap bulat */
                            outline: none;
                            background-color: white;
                            /* Set background warna putih */
                            position: relative;
                            display: flexbox;
                            margin-right: 2px;
                        }


                        .form-check-container {
                            display: flex;
                            /* Gunakan flexbox untuk membuat elemen bersampingan */
                            justify-content: center;
                            /* Posisikan elemen di tengah secara horizontal */
                            align-items: center;
                            /* Posisikan elemen di tengah secara vertikal */
                            margin-bottom: 15px;
                            /* Tambahkan margin bawah untuk spasi */
                        }

                        .form-check {
                            margin-right: 15px;
                            /* Tambahkan jarak antar radio button */
                            display: flex;
                            /* Buat label dan input bersampingan */
                            align-items: center;
                        }

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

                            .tanggal,
                            .jam,
                            .selesai {
                                width: 100%;
                                /* Lebar penuh pada layar kecil */
                            }
                        }
                    </style>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pinjam">Pinjam</button>
                    <button type="button" style="width: 200px;" class="btn btn-warning ml-3" data-bs-toggle="modal"
                        data-bs-target="#print">
                        <i class="fas fa-fw fa-print"></i>PRINT
                    </button>

                    <div class="row">
                        <div class="col-lg-8">
                            <br>
                            <?= $this->session->flashdata('message') ?>
                        </div>
                    </div>

                    <?php
                    $queryLab = 'Select * FROM lab where id > 2';
                    $lab = $this->db->query($queryLab)->result_array();
                    $namaLab = [];
                    foreach ($lab as $l) {
                        $namaLab[$l['id']] = $l['nama'];
                    }
                    if ($user['level'] > 2) {
                        $querLabLevel = "SELECT * FROM pinjam WHERE nama_lab = '" . $namaLab[$user['level']] . "'";
                        $pinjam = $this->db->query($querLabLevel)->result_array();
                    } else {
                        $queryPinjam = 'Select * FROM pinjam';
                        $pinjam = $this->db->query($queryPinjam)->result_array();
                    }
                    ?>

                    <table id="kontol" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>penginput</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen Pengajar</th>
                                <th>Kelas</th>
                                <th>Nama Wakil Mahasiswa</th>
                                <th>Hari & Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Teori/Praktek</th>
                                <th>Nama Lab</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($pinjam as $p) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $p['penginput'] ?></td>
                                    <td><?= $p['matkul'] ?></td>
                                    <td><?= $p['dosen_pengajar'] ?></td>
                                    <td><?= $p['kelas'] ?></td>
                                    <td><?= $p['wakil_mhs'] ?></td>
                                    <td><?= $p['tanggal_pinjam'] ?></td>
                                    <td><?= $p['jam'] ?></td>
                                    <td><?= $p['selesai'] ?></td>
                                    <td><?= $p['Teori/Praktek'] ?></td>
                                    <td><?= $p['nama_lab'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#editModal<?= $p['id'] ?>"><i
                                                class="fas fa-fw fa-edit"></i></button>
                                        <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Jadwal</h1>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('KalabTeknisi/editPinjam') ?>"
                                                            method="post">
                                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                            <div class="form-group">
                                                                <label for="matkul">Nama Matkul : </label>
                                                                <input type="text" name="matkul" id="matkul"
                                                                    placeholder="Masukkan Mata Kuliah"
                                                                    value="<?= $p['matkul'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kelas">Nama Dosen Pengajar : </label>
                                                                <input type="text" name="peminjam" id="peminjam"
                                                                    placeholder="Nama Dosen Pengajar"
                                                                    value="<?= $p['dosen_pengajar'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kelas">Nama Kelas : </label>
                                                                <input type="text" name="kelas" id="kelas"
                                                                    placeholder="Nama Kelas" value="<?= $p['kelas'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mhs">Nama Wakil Mahasiswa : </label>
                                                                <input type="text" name="mhs" id="mhs"
                                                                    placeholder="Nama Wakil Mahasiswa"
                                                                    value="<?= $p['wakil_mhs'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal">Tanggal Pinjam : </label>
                                                                <input type="date" name="tanggal"
                                                                    value="<?= $p['tanggal_pinjam'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mulai">Jam Mulai : </label>
                                                                <input type="time" name="mulai"
                                                                    value="<?= $p['jam'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="selesai">Jam Selesai : </label>
                                                                <input type="time" name="selesai"
                                                                    value="<?= $p['selesai'] ?>">
                                                            </div>
                                                            <div class="form-check-container">
                                                                <div class="form-check">
                                                                    <input class="radioTeori" type="radio"
                                                                        name="teori" id="teori" value="Teori"
                                                                        <?php if ($p['Teori/Praktek'] == 'Teori') {
                                                                            echo 'checked';
                                                                        } ?>>
                                                                    <label class="form-check-label" for="teori">
                                                                        Teori
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radioTeori" type="radio"
                                                                        name="teori" id="teori" value="Praktek"
                                                                        <?php if ($p['Teori/Praktek'] == 'Praktek') {
                                                                            echo 'checked';
                                                                        } ?>>
                                                                    <label class="form-check-label" for="teori">
                                                                        Praktek
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <?php if ($user['level'] != 1) : ?>
                                                                    <input type="hidden" name="lab" id="lab"
                                                                        value="<?= $namaLab[$user['level']] ?>">
                                                                <?php else :  ?>
                                                                    <label for="">Pilih Lab : </label>
                                                                    <select name="lab" id="lab"
                                                                        style="width: 300px;">
                                                                        <?php foreach ($lab as $l) : ?>
                                                                            <option value="<?= $l['nama'] ?>" <?php if ($p['nama_lab'] == $l['nama']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>>
                                                                                <?= $l['nama'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                <?php endif; ?>
                                                            </div>


                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#hapusModal<?= $p['id'] ?>"><i
                                                class="fas fa-fw fa-trash"></i></button>
                                        <div class="modal fade" id="hapusModal<?= $p['id'] ?>" tabindex="-1"
                                            aria-labelledby="hapusModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusModalLabel">Hapus Jadwal
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('KalabTeknisi/hapusPinjam') ?>"
                                                            method="post">
                                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
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

                    <!-- Button trigger modal -->
                </div>

                <!-- Modal -->
                <div class="modal fade" id="print" tabindex="-1" aria-labelledby="printLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="printLabel">Print SIMPLE 1 bulan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('KalabTeknisi/print') ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="tanggal">Pilih Tanggal : </label>
                                        <input type="month" name="tanggal" id="tanggal">
                                    </div>
                                    <div class="form-group">

                                        <?php if ($user['level'] != 1) :  ?>
                                            <input type="hidden" name="lab" value="<?= $namaLab[$user['level']] ?>">
                                        <?php else :  ?>
                                            <label for="tanggal">Pilih lab : </label>
                                            <select name="lab" id="lab">
                                                <option value="" selected>Pilih Lab </option>
                                                <?php foreach ($lab as $l) : ?>
                                                    <option value="<?= $l['nama'] ?>"><?= $l['nama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-fw fa-print"></i>Print</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pinjam" tabindex="-1" aria-labelledby="pinjamLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="pinjamLabel">Pinjam Lab</h1>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('KalabTeknisi/pinjam') ?>" method="post">
                                    <div class="container">
                                        <div class="form-group">
                                            <label for="matkul">Mata Kuliah : </label>
                                            <input type="text" class="form-control" name="matkul" id="matkul"
                                                placeholder="Masukkan Mata Kuliah">
                                        </div>
                                        <div class="form-group">
                                            <label for="peminjam">Dosen Pengajar :</label>
                                            <input type="text" class="form-control" name="peminjam"
                                                id="peminjam" placeholder="Masukkan Dosen Pengajar">
                                        </div>
                                        <div class="form-group">
                                            <label for="kelas">Kelas : </label>
                                            <input type="text" class="form-control" name="kelas" id="kelas"
                                                placeholder="Masukkan Nama Kelas">
                                        </div>
                                        <div class="form-group">
                                            <label for="mhs">Nama Perwakilan Mahasiswa : </label>
                                            <input type="text" class="form-control" name="mhs" id="mhs"
                                                placeholder="Nama perwakilan mahasiswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="form-check">Teori / Praktek</label>
                                            <div class="form-check">
                                                <input class="radioTeori" type="radio" name="teori" id="teori" value="Teori" checked>
                                                <label for="teori" class="form-check-label">Teori</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="radioTeori" type="radio" name="teori" id="teori" value="Praktek">
                                                <label for="praktek" class="form-check-label">Praktek</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="penginput"
                                                id="penginput" value="<?= $user['email'] ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Pilih Tanggal : </label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                                style="max-width: fit-content;">
                                        </div>
                                        <div class="form-group">
                                            <label for="mulai">Jam Mulai : </label>
                                            <input type="time" name="mulai" id="mulai"
                                                style="max-width: fit-content;">
                                        </div>
                                        <div class="form-group">
                                            <label for="selesai">Jam Selesai : </label>
                                            <input type="time" name="selesai" id="selesai"
                                                style="max-width: fit-content;">
                                        </div>
                                        <?php if ($user['level'] != 1) : ?>
                                            <input type="hidden" name="lab" id="lab"
                                                value="<?= $namaLab[$user['level']] ?>">
                                        <?php else : ?>
                                            <div class="form-group">
                                                <center>
                                                    <label for="lab">Pilih Lab : </label>
                                                    <select name="lab" id="lab" style="width: 300px;">
                                                        <option value="">Pilih Lab</option>
                                                        <?php foreach ($lab as $m) : ?>
                                                            <Option value="<?= $m['nama'] ?>"><?= $m['nama'] ?></Option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </center>
                                            </div>
                                        <?php endif; ?>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    document.querySelectorAll('input[name="teori"]').forEach((radio) => {
                        radio.addEventListener('change', function(event) {
                            event.preventDefault(); // Cegah aksi default jika diperlukan

                            // Bisa tambahkan logika custom sebelum mengizinkan perubahan
                            console.log('Radio button changed to:', event.target.value);
                        });
                    });
                </script>


                <!-- End of Main Content -->