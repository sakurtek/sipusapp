<?php

require_once "../modul/modul.php";

if (isset($_POST["submit"]) or 
        isset($_GET["id"]))
{
    // simpan seluruh variabel form ke dalam
    // variabel array agar lebih mudah untuk di kirim
    // ke proses data
    
    $data = array(	
        "id_anggota"    => htmlentities($_POST['id_anggota'],ENT_QUOTES), 
        "nama"          => htmlentities($_POST['nama'],ENT_QUOTES), 
        "jenis_kelamin" => htmlentities($_POST['jenis_kelamin'],ENT_QUOTES), 
        "alamat"        => htmlentities($_POST['alamat'], ENT_QUOTES), 
        "status"        => "Tidak Meminjam", 
        "nama_file"     => htmlentities($_FILES['foto']['name'],ENT_QUOTES),
        "page"          => htmlentities($_POST['page'],ENT_QUOTES),
        "foto_awal"     => htmlentities($_POST["foto_awal"], ENT_QUOTES) 
    );

    extract($data, EXTR_PREFIX_SAME, "wddx");

    if ($_POST["submit"] == "simpan") {
        // jika simpan atur disini
        // jalankan fungsi processAddUser()
        // untuk melakukan proses penyimpanan data
        processAddUser ($data, $_POST["submit"]);

    }else if($_POST["submit"] == "update"){
        // jalankan fungsi processUpdateUser, dengan paramater
        // 1. array data dari form
        // 2. parameter tombol proses untuk update data
        processUpdateUser ($data, $_POST['submit']);

    }else{
        // menjalankan fungsi processDeleteUser()
        // dengan parameter $_GET['id']
        processDeleteUser ($_GET['id']);
    }
}