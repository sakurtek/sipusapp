<?php

require_once "define.php";

/* 
	Revisi modul dengan menggunakan konsep MODULAR 
	setiap masalah dipecah menjadi bagian - bagian yang lebih kecil
	atau yang di kenal dengan nama subrutin
	modifkasi oleh Stendy B. Sakur (Politeknik Negeri Nusa Utara)

	fungsi untuk membuat koneksi ke database mysql
	dengan menggunakan fungsi MySQLi 	
		
	untuk membuat koneksi dengan database 
	komponen terdiri dari:
	hostname	: localhost / 127.0.0.1
	username	: masukkan username dari database
	password	: password  database
	port		: masukkan port biasanya 3306
	database	: masukkan nama database
*/

function getConnection() 
{
	/* 
		Buat koneksi dengan database
		gunakan MySQLi dengan perintah
		mysqli_connect(hostname, username, password, database, port)
	*/

	$db = mysqli_connect(SERVER, USER, PASS, DATABASE, PORT);

	// Periksa jika gagal koneksi diputuskan dan erro ditampilkan
	if( !$db ){
    	die("Gagal terhubung dengan database: " . mysqli_connect_error());
	}

	/* Jika berhasil kembalikan nilai koneksi */
	return $db;
}

/* Fugsi untuk memeriksa jika pengguna masuk tanpa login */
function getErrorLogin()
{
	/* Aktifkan Session Start */
	session_start();
	if (!isset($_SESSION['sesi']))
	{
		echo "<script> alert('Anda Harus Login Dahulu!'); </script>";
		header('location:login.php');
	}
}

/* 
	Membuat fungsi untuk melakukan proses login
	dari user atau admin
*/
function loginUser ($userLogin, $passLogin, $submit)
{
	if(isset($submit))
	{
		$user	= isset($userLogin) ? htmlentities($userLogin,ENT_QUOTES) : "";
		$pass	= isset($passLogin) ? htmlentities($passLogin,ENT_QUOTES) : "";
		$sql 	= "SELECT * FROM admin WHERE BINARY username = '$user' AND password = sha1('$pass')";
		$qry	= mysqli_query(getConnection(), $sql);
		$sesi	= mysqli_num_rows($qry);

		if ($sesi == 1)
		{
			$data_admin	= mysqli_fetch_array($qry);
			$_SESSION['id_admin'] = $data_admin['id_admin'];
			$_SESSION['sesi'] = $data_admin['nm_admin'];
				
			echo "<script>alert('Anda berhasil Log In');</script>";
			echo "<meta http-equiv='refresh' content='0; url=index.php?user=$sesi'>";
		}else{
			echo "<meta http-equiv='refresh' content='0; url=login.php'>";
			echo "<script>alert('Anda Gagal Log In');</script>";
		}
	}else{
	  include "login.php";
	}
}

function getLogout ()
{
	session_start();
	unset($_SESSION['sesi']);
	unset($_SESSION['id_admin']);
	session_destroy();
	header("Location:index.php");
}

function getPage ($get_page)
{
	// definisi lokasi tempat menyimpan halaman / page
	$pages_dir = 'pages';

	// periksa apakah page koosong
	if(!empty($get_page)){ 

		$pages=scandir($pages_dir,0);
		
		unset($pages[0],$pages[1]);
		
		$p=$get_page;
		
		if(in_array($p.'.php',$pages)){
			include($pages_dir.'/'.$p.'.php');
		}else{
			echo'Halaman Tidak Ditemukan';
		}

	}else{
		// jika page koosng maka tampillan beranda.php
		include($pages_dir . '/beranda.php');
	}
}

/* 
	page: anggota.php 
	fungsi: menampilkan anggota
	nama fungsi: getTampilAnggotaRev()
	param: 	$pg, untuk menampilkan halaman keberapa
			$req, untuk memasukkan variabel req
	tujuan: untuk menampilkan anggota
*/

function getTampilAnggotaRev($pg, $req)
{
	
	$batas = 5;
	extract($pg);

	if(empty($hal)){
		$posisi = 0;
		$hal = 1;
		$nomor = 1;
	}else {
		$posisi = ($hal - 1) * $batas;
		$nomor = $posisi+1;
	}	

	// periksa apakah yang masuk adalah Paramter POST
	// jika benar maka buat buat query
	if($req == "POST")
	{
		$pencarian = trim(mysqli_real_escape_string(getConnection(), htmlentities($_POST['pencarian'], ENT_QUOTES)));

		if($pencarian != ""){
			$sql = "SELECT * FROM tbanggota WHERE nama LIKE '%$pencarian%'
					OR idanggota LIKE '%$pencarian%'
					OR jeniskelamin LIKE '%$pencarian%'
					OR alamat LIKE '%$pencarian%'";
				
			$query = $sql;
			$queryJml = $sql;	
						
		} else {
			$query = "SELECT * FROM tbanggota LIMIT $posisi, $batas";
			$queryJml = "SELECT * FROM tbanggota";
			$no = $posisi * 1;
		}			
	}else {
		$query = "SELECT * FROM tbanggota LIMIT $posisi, $batas";
		$queryJml = "SELECT * FROM tbanggota";
		$no = $posisi * 1;
	}
		
	// menjlankan query berdasarakan sql diatas
	$q_tampil_anggota = mysqli_query(getConnection(), $query);

	if(mysqli_num_rows($q_tampil_anggota)>0)
	{
		while($r_tampil_anggota=mysqli_fetch_array($q_tampil_anggota))
		{
			if(empty($r_tampil_anggota['foto']) or ($r_tampil_anggota['foto']=='-'))
			{
				$newfoto = "admin-no-photo.jpg";
			}else{
				$newfoto = $r_tampil_anggota['foto'];
			}

			/*
				Diubah menggunakan Media Object
			*/
			echo "<div class='media border p-2'>";
			echo "<img src=foto/$newfoto class='rounded-circle align-self-start mr-3' width=70px height=70px>";
			echo "<span class='badge badge-primary'>" . $nomor . "</span>&nbsp;";

			echo "<div class='media-body'>"; // media
			echo "<div class='row'>"; // row

			echo "<div class='col-sm py-0 px-3'>"; // col1

			echo "<h4>" . strtoupper($r_tampil_anggota['nama']). "</h4>";
			echo "<p>";
			echo "Jenis Kelamin: " .strtoupper($r_tampil_anggota['jeniskelamin']);
			echo ", beralamat di " . strtoupper($r_tampil_anggota['alamat']) ;
			echo "</p>";

			echo "</div>";

			echo "<div class='col-sm'>"; // col2
			// tempat tombol

			echo "<div class='nav justify-content-end'>";
			echo "<div class='btn-group btn-group-sm'>";
			echo "<a href=pages/cetak_kartu.php?id=$r_tampil_anggota[idanggota]  target=_blank class='btn btn-outline-info' role='button'>Cetak Kartu</a>";

			echo "<a href=index.php?p=anggota-edit&id=$r_tampil_anggota[idanggota]&hal=$hal class='btn btn-outline-success' role='button'>Edit</a>";
			
			echo "<a href=proses/proses.php?id=$r_tampil_anggota[idanggota] onclick =\"return confirm ('Apakah Anda Yakin Akan Menghapus Data Ini?');\" class='btn btn-outline-danger' role='button'>Hapus</a>";
			echo "</div>";
			echo "</div>";

			echo "</div>"; // end col2

			echo "</div>"; // row
			echo "</div>"; // media

			echo "</div>";	
			echo "<br />";
			$nomor++; 
		} 
	}else {
		echo "Data Tidak Ditemukan";
	}

	echo "</div>";

	// akhir tampil data
	if(isset($_POST['pencarian']))
	{
		if($_POST['pencarian']!=''){
			echo "<div style=\"float:left;\">";
			$jml = mysqli_num_rows(mysqli_query(getConnection(), $queryJml));
			echo "Data Hasil Pencarian: <b>$jml</b>";
			echo "</div>";
		}
	}else{
	
		echo "<div class='container-fluid'>";
		echo "<div class='row'>";
		echo "<div class='col-sm'>";
		echo "<div class='text-left'>";		
		$jml = mysqli_num_rows(mysqli_query(getConnection(), $queryJml));
		echo "Jumlah Data : <b>$jml</b>";
		echo "</div>";	
		echo "</div>";

		echo "<div class='col-sm'>";
		echo "<div class='pagination'>";
		$jml_hal = ceil($jml/$batas);
		echo "<ul class='pagination float-right'>";
		for($i=1; $i<=$jml_hal; $i++){
			if($i != $hal){
				echo "<li class='page-item'>";
				echo "<a class='page-link' href=\"?p=anggota&hal=$i\">$i</a>";
				echo "</a>";
			}else {
				echo "<li class='page-item active'>";
				echo "<a class='page-link'>$i</a>";
				echo "</li>";
			}
		}
		echo "</ul>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}
}

function getLayoutPrint ()
{	
	$nomor	= 1;
	$sql	= "SELECT * FROM tbanggota ORDER BY idanggota DESC";
	$q_tampil_anggota = mysqli_query(getConnection(), $sql);
	
	if(mysqli_num_rows($q_tampil_anggota)>0)
	{
		while($r_tampil_anggota=mysqli_fetch_array($q_tampil_anggota))
		{
			if(empty($r_tampil_anggota['foto']) or ($r_tampil_anggota['foto']=='-'))
			{
				$foto = "admin-no-photo.jpg";
			} else{
				$foto = $r_tampil_anggota['foto'];
			}

			echo "<tr>";
			echo "<td>" . $nomor . "</td>";
			echo "<td>" . $r_tampil_anggota['idanggota'] . "</td>";
			echo "<td>" . strtoupper($r_tampil_anggota['nama']) . "</td>";
			echo "<td><img src=../foto/" . $foto . " class='rounded-circle' width=70px height=70px></td>";
			echo "<td>" . strtoupper($r_tampil_anggota['jeniskelamin']) . "</td>";
			echo "<td>" . strtoupper($r_tampil_anggota['alamat']) . "</td>";		
			echo "</tr>";		
		
			$nomor++;
		}
	}
}

/* modif dengan menyiman nama file asli dari foto */
function processAddUser ($arr=array(), $post)
{
	if(isset($post)){

		extract($arr, EXTR_PREFIX_SAME, "wddx");

		if(!empty($nama_file))
		{
			// Baca lokasi file sementar dan nama file dari form (fupload)
			$lokasi_file = $_FILES['foto']['tmp_name'];

			$tipe_file = pathinfo($nama_file, PATHINFO_EXTENSION); // original
			$num_file_foto = rand(10000,99999);
			$file_foto = $num_file_foto . "." . $tipe_file;

			// Tentukan folder untuk menyimpan file
			$folder = "../foto/$file_foto";

			// Apabila file berhasil di upload
			move_uploaded_file($lokasi_file,$folder);

		}else {
			$file_foto="-";
		}

		if (!empty($id_anggota) && !empty($nama) && 
				!empty($alamat))
		{
			$sql = " INSERT INTO tbanggota VALUES ('$id_anggota','$nama','$jenis_kelamin','$alamat','$status', '$file_foto')";
			$query = mysqli_query(getConnection(), $sql);
		}
		
		header("location:../index.php?p=anggota");
		exit;
	}
}


/* */
function processUpdateUser ($arr=array(), $post)
{
	if (isset($post)){
	
		extract($arr, EXTR_PREFIX_SAME, "wddx");

		echo $nama_file;

		// periksa jika nama file foto ada
		// jika tidak maka gunakan foto yang lama
		if(!empty($nama_file))
		{
			echo "masuk ke fungsi update data..";

			// Baca lokasi file sementar dan nama file dari form (fupload)
			$lokasi_file = $_FILES['foto']['tmp_name'];
			
			// dimodifikasi dari file asli
			// dimana nama file foto disimpan ke dalam database
			// menggunakan bilangan random tmbah extension

			$tipe_file = pathinfo($nama_file, PATHINFO_EXTENSION); // original
			$num_file_foto = rand(10000,99999);
			$file_foto = $num_file_foto . "." . $tipe_file;
		
			// Tentukan folder untuk menyimpan file
			$folder = "../foto/$file_foto";

			if (move_uploaded_file($lokasi_file,"$folder")){
				// susun penamaan file lama
				$file_lama = "../foto/" . $foto_awal;

				// hapus file yang lama
				unlink($file_lama);
			}

		}else{
			// devinisi variabel file_foto dengan foto awal
			$file_foto=$foto_awal;
		}
	
		// periksa apakah data id_anggota, nama dan alamat tidak kosong
		if (!empty($id_anggota) && !empty($nama) && 
				!empty($alamat))
		{
			// lakukan proses perubahan data ke database
			$sql = "UPDATE tbanggota
			SET nama='$nama',jeniskelamin='$jenis_kelamin',alamat='$alamat',foto='$file_foto'
			WHERE idanggota='$id_anggota'";

			mysqli_query(getConnection(), $sql);	
		}

		// pindah ke halamana index.php
		// dengan variabel anggota dan halaman
		header("location:../index.php?p=anggota&hal=$page");
		exit;
	}
}

function processDeleteUser ($id)
{
	// untuk menghapus data maka hapus terlebih dahulu
	// file foto yang sudah tidak dipakai
	// ambil dahulu nama file
	$sql 	= "select * from tbanggota where idanggota='$id'";
	$qdel	= mysqli_query(getConnection(), $sql);
	$result = mysqli_fetch_array($qdel);
	$nama_foto = $result['foto'];

	$file_path = "../foto/" . $nama_foto;

	// jika file foto ada maka segera dihapus 
	if ($nama_foto != "-")
	{
		if (unlink($file_path)){
			// jika file berhasil dihapus 
			// maka hapus database yang bersesuai
			$sqlDel = "DELETE FROM tbanggota WHERE idanggota='$id'";
		}	
	}else{
		// jika ternyata tidak ada gambar
		// maka cukup dihapus databasenya saja
		$sqlDel = "DELETE FROM tbanggota WHERE idanggota='$id'";
	}

	// hapus data
	mysqli_query(getConnection(), $sqlDel);

	// redirect
	header("location:../index.php?p=anggota");
	exit;
}

function getUserForUpdate ($get)
{
	extract($get);

	$sql = "SELECT * FROM tbanggota WHERE idanggota='$id' ";
 	
	$q_tampil_anggota = mysqli_query(getConnection(), $sql);

	$r_tampil_anggota=mysqli_fetch_array($q_tampil_anggota);
		
	if(empty($r_tampil_anggota['foto']) or ($r_tampil_anggota['foto']=='-')) {

		$foto = "admin-no-photo.jpg";		
	}else{
		$foto = $r_tampil_anggota['foto'];
	}

	$arr = array(	"id_anggota"=>$r_tampil_anggota['idanggota'], 
					"nama"=>$r_tampil_anggota['nama'], 
					"jeniskelamin"=>$r_tampil_anggota['jeniskelamin'], 
					"alamat"=>$r_tampil_anggota['alamat'], 
					"status"=>$r_tampil_anggota['status'], 
					"foto"=>$foto, 
					"page"=>$hal);

	return $arr;
}

function getPrintKartuUser ($post)
{
	$id_anggota = $post;

	$q_tampil_anggota=mysqli_query(getConnection(), "SELECT * FROM tbanggota WHERE idanggota='$id_anggota'");
	$r_tampil_anggota=mysqli_fetch_array($q_tampil_anggota);
	
	if(empty($r_tampil_anggota['foto'])or($r_tampil_anggota['foto']=='-'))
	{
		$foto = "admin-no-photo.jpg";
	} else{
		$foto = $r_tampil_anggota['foto'];
	}

	// simpan ke dalam array 
	$arr = array ( "idanggota"=>$r_tampil_anggota['idanggota'], 
					"nama"=>$r_tampil_anggota['nama'], 
					"jeniskelamin"=>$r_tampil_anggota['jeniskelamin'],
					"alamat"=>$r_tampil_anggota['alamat'],
					"foto"=>$foto);

	return $arr;
}

function checkJenisKelamin ($jk)
{
	if($jk == "Pria") {
		return 'checked';
	}else{
		return 'checked';
	}
}