<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relasi</title>
</head>
<body>
    <h2>Tambah Data Pegawai</h2>

    <form action="" method="post">
        <table>
            <tr>
                <td width="100">NIK</td>
                <td><input type="text" name="no_induk" required></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" size="30" required></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>
                    <select name="id_jab" required>
                        <option value="">---</option>
                        <?php
                        include "koneksi.php";
                        $query = mysqli_query($koneksi, "SELECT * FROM jabatan") or die(mysqli_error($koneksi));
                        while($data = mysqli_fetch_array($query)){
                            echo "<option value='".$data['id_jab']."'>".$data['nama_jab']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Simpan" name="proses"></td>
            </tr>
        </table>
    </form>

    <?php
include "koneksi.php";

if (isset($_POST['proses'])) {

    $no_induk = mysqli_real_escape_string($koneksi, $_POST['no_induk']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_jab = mysqli_real_escape_string($koneksi, $_POST['id_jab']);

    if ($no_induk == "" || $nama == "" || $id_jab == "") {
        echo "Semua data harus diisi!";
    } else {
        $cek_jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE id_jab = '$id_jab'");
        if (mysqli_num_rows($cek_jabatan) == 0) {
            echo "Jabatan tidak valid!";
        } else {
            $query = "INSERT INTO pegawai (no_induk, nama, id_jab) VALUES ('$no_induk', '$nama', '$id_jab')";
            if (mysqli_query($koneksi, $query)) {
                header("Location: lihatdata.php");
                exit();
            } else {
                echo "Terjadi kesalahan: " . mysqli_error($koneksi);
            }
        }
    }
}
?>


</body>
</html>
