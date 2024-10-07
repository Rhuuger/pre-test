<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
</head>
<body>
    <h2>Data Pegawai</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "koneksi.php"; 
            $query = "SELECT pegawai.no_induk, pegawai.nama, jabatan.nama_jab, jabatan.gaji_pokok, jabatan.tunjangan
                      FROM pegawai
                      JOIN jabatan ON pegawai.id_jab = jabatan.id_jab";
            $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

            if (mysqli_num_rows($result) > 0) {
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['no_induk']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['nama_jab']}</td>
                        <td>{$row['gaji_pokok']}</td>
                        <td>{$row['tunjangan']}</td>
                        <td>
                            <a href='edit.php?no_induk={$row['no_induk']}'>Edit</a> |
                            <a href='tampil_data.php?delete={$row['no_induk']}' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                        </td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data pegawai ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['delete'])) {
        $no_induk = mysqli_real_escape_string($koneksi, $_GET['delete']);
        $query_delete = "DELETE FROM pegawai WHERE no_induk='$no_induk'";
        if (mysqli_query($koneksi, $query_delete)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='lihatdata.php';</script>";
        } else {
            echo "Terjadi kesalahan saat menghapus data: " . mysqli_error($koneksi);
        }
    }
    ?>
</body>
</html>
