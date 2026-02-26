<?php
$conn = mysqli_connect("localhost","root","","db_biodata");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM mahasiswa WHERE id='$id'"));

if(isset($_POST['update'])){

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $universitas = $_POST['universitas'];
    $program_studi = $_POST['program_studi'];
    $angkatan = $_POST['angkatan'];
    $pengalaman = $_POST['pengalaman'];

    if($_FILES['foto']['name'] != ""){

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_baru = time().".".$ext;
        $tmp = $_FILES['foto']['tmp_name'];

        move_uploaded_file($tmp, "images/".$nama_baru);

        if(file_exists("images/".$data['foto'])){
            unlink("images/".$data['foto']);
        }

        mysqli_query($conn,"UPDATE mahasiswa SET
        nama='$nama',
        nim='$nim',
        universitas='$universitas',
        program_studi='$program_studi',
        angkatan='$angkatan',
        pengalaman='$pengalaman',
        foto='$nama_baru'
        WHERE id='$id'");
    } else {

        mysqli_query($conn,"UPDATE mahasiswa SET
        nama='$nama',
        nim='$nim',
        universitas='$universitas',
        program_studi='$program_studi',
        angkatan='$angkatan',
        pengalaman='$pengalaman'
        WHERE id='$id'");
    }

    echo "<script>alert('Data berhasil diupdate');window.location='team.php';</script>";
}
?>

<form method="POST" enctype="multipart/form-data">
    <img src="images/<?php echo $data['foto']; ?>" width="100"><br><br>
    Ganti Foto: <input type="file" name="foto"><br><br>

    Nama: <input type="text" name="nama" value="<?php echo $data['nama']; ?>"><br>
    NIM: <input type="text" name="nim" value="<?php echo $data['nim']; ?>"><br>
    Universitas: <input type="text" name="universitas" value="<?php echo $data['universitas']; ?>"><br>
    Program Studi: <input type="text" name="program_studi" value="<?php echo $data['program_studi']; ?>"><br>
    Angkatan: <input type="number" name="angkatan" value="<?php echo $data['angkatan']; ?>"><br>
    Pengalaman: <textarea name="pengalaman"><?php echo $data['pengalaman']; ?></textarea><br><br>

    <button type="submit" name="update">Update</button>
</form>