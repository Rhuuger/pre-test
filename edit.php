<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
</head>
<body>
    <h2>Edit Data Pegawai</h2>

    <?php
    include "koneksi.php";
    if (isset($_GET['no_induk'])) {
        $no_induk = mysqli_real_escape_string($koneksi, $_GET['no_induk']);
        $query = "SELECT pegawai.no_induk, pegawai.nama, pegawai.id_jab, jabatan.nama_jab
                  FROM pegawai
                  JOIN jabatan ON pegawai.id_jab = jabatan.id_jab
                  WHERE pegawai.no_induk='$no_induk'";
        $result = mysqli_query($koneksi, $query);
        $data = mysqli_fetch_assoc($result);
        if ($data) {
            ?>
            <form action="" method="post">
                <input type="hidden" name="no_induk" value="<?php echo $data['no_induk']; ?>">
                <table>
                    <tr>
                        <td>NIK</td>
                        <td><input type="text" name="nik" value="<?php echo $data['no_induk']; ?>" required readonly></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>
                            <select name="id_jab" required>
                                <option value="">---</option>
                                <?php
                                $jabatan_query = mysqli_query($koneksi, "SELECT * FROM jabatan");
                                while ($jabatan = mysqli_fetch_array($jabatan_query)) {
                                    $selected = ($jabatan['id_jab'] == $data['id_jab']) ? 'selected' : '';
                                    echo "<option value='{$jabatan['id_jab']}' $selected>{$jabatan['nama_jab']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="update" value="Update"></td>
                    </tr>
                </table>
            </form>
            <?php
        } else {
            echo "Data tidak ditemukan!";
        }
    }

    if (isset($_POST['update'])) {
        $nik = mysqli_real_escape_string($koneksi, $_POST['no_induk']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $id_jab = mysqli_real_escape_string($koneksi, $_POST['id_jab']);

        $update_query = "UPDATE pegawai SET no_induk='$nik', nama='$nama', id_jab='$id_jab' WHERE no_induk='$nik'";
        if (mysqli_query($koneksi, $update_query)) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location='lihatdata.php';</script>";
        } else {
            echo "Terjadi kesalahan saat memperbarui data: " . mysqli_error($koneksi);
        }
    }
    ?>
</body>
</html>
