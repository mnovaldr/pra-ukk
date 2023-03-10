<?php
include '../layouts/header_admin.php';
include '../layouts/navbar_admin.php';

if (isset($_POST['simpan'])) {
    $harga_kamar = $_POST['harga_kamar'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $foto_kamar = $_FILES['foto_kamar']['name'];
    $jml_kamar = $_POST['jml_kamar'];

    if ($foto_kamar !="") {
        $ekstensi_diperbolehkan = array('png','jpg','jpeg');
        $x = explode('.', $foto_kamar);
        $extensi = strtolower(end($x));
        $file_tmp = $_FILES['foto_kamar']['tmp_name'];
        $angka_acak = rand(1,999);
        $nama_gambar_baru = $angka_acak.'-'.$file_tmp;
        if (in_array($extensi, $ekstensi_diperbolehkan) == true) {
            move_uploaded_file($file_tmp, 'uploads/'.$nama_gambar_baru);
            $query = "INSERT INTO tb_kamar  VALUES ('', '$harga_kamar', '$tipe_kamar', '$nama_gambar_baru', '$jml_kamar')";
            $result = mysqli_query($koneksi, $query);
    
            if (!$result) {
                die("Query gagal dijalankan : ".mysqli_errno($koneksi)."-".mysqli_error($koneksi));
            } else {
                echo "<script>alert('Data berhasil ditambah.');window.location='kamar.php';</script>";
            }
            
        } else {
            echo "<script>alert('Extensi gambar harus png atau jpg.');window.location='kamar.php';</script>";
        }
        
    } else {
        $query = "INSERT INTO kamar (no_kamar,foto_$file_tmp) VALUES ('$no_kamar', null)";
        $result = mysqli_query($koneksi, $query);
    
        if (!$result) {
            die("Query gagal dijalankan : ".mysqli_errno($koneksi)."-".mysqli_error($koneksi));
        } else {
            echo "<script>alert('Data berhasil ditambah.');window.location='kamar.php';</script>";
        }
    }
} else {
    # code...
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Data Kamar </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Data Kamar</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah-kamar">
                                            <i class="fas fa-plus"></i> Tambah Kamar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php
                            if (isset($_GET['info'])) {
                                if ($_GET['info'] == "hapus") { ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-trash"></i> Sukses</h5>
                                        Data berhasil di hapus
                                    </div>
                                <?php } else if ($_GET['info'] == "simpan") { ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i> Sukses</h5>
                                        Data berhasil di simpan
                                    </div>
                                <?php } else if ($_GET['info'] == "update") { ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-edit"></i> Sukses</h5>
                                        Data berhasil di update
                                    </div>
                            <?php }
                            } ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Harga Kamar</th>
                                        <th>Tipe Kamar</th>
                                        <th>Gambar Kamar</th>
                                        <th>Jumlah Kamar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <!-- Modal Edit Barang -->
                                    <div class="modal fade" id="modal-edit">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="update_barang.php" method="post">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Barang</label>
                                                            <input type="text" value="<?= $data['id_barang']; ?>" name="id_barang" class="form-control" hidden>
                                                            <input type="text" value="<?php echo $data['nama_barang']; ?>" class="form-control" name="nama_barang">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Barang</label>
                                                            <input type="date" value="<?= $data['tgl']; ?>" class="form-control" name="tgl">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga Barang</label>
                                                            <input type="number" value="<?php echo $data['harga_awal']; ?>" class="form-control" name="harga_awal">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi Barang</label>
                                                            <textarea name="deskripsi_barang" class="form-control" rows="3"><?php echo $data['deskripsi_barang']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .Modal Edit Barang -->

                                    <!-- Modal Hapus Barang -->
                                    <div class="modal fade" id="modal-hapus">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda Menghapus Data Barang <b><?php echo $data['nama_barang']; ?></b> ini?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <a href="hapus_barang.php?id_barang=" class="btn btn-primary">Hapus</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .Modal Hapus Barang -->
                                </tbody>
                            </table>
                            <!-- Modal Tambah Kamar -->
                            <div class="modal fade" id="modal-tambah-kamar">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah Kamar</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Harga Kamar</label>
                                                    <input type="number" class="form-control" name="harga_kamar" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tipe Kamar</label>
                                                    <select name="tipe_kamar" class="form-control">
                                                        <option value="">Pilih Kamar</option>
                                                        <option value="standar">Standart</option>
                                                        <option value="single">Single</option>
                                                        <option value="deluxe">Deluxe</option>
                                                        <option value="suite">Duite</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Gambar Kamar</label>
                                                    <input type="file" name="foto_kamar" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jumlah Kamar</label>
                                                    <input type="number" class="form-control" name="jml_kamar" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- .Modal Tambah Barang -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include '../layouts/footer_admin.php';
?>