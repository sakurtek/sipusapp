<?php 
require_once "modul/modul.php"; 
getErrorLogin();
?>

<!DOCTYPE html>
<html lang="eng">
<head>
	<title>Sistem Informasi Perpustakaan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="plugin/bootstrap-5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="plugin/bootstrap-5.2.0/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color:#343A40;">
	<!-- HEADER -->
	<div class="jumbotron bg-dark text-white mt-4 p-4" style="margin-top:0">
		<h1>Perpustakkan Umum</h1>
		<p>Jl. Lembah Abang No 11, Telp: (021)55555555</p>
	</div>

	<!-- INFO -->
	<div class="container-fluid p-2 bg-danger text-white">
		Vocational School Graduate Academy | VSGA 
		<div style="float:right">Hai <?php echo$_SESSION['sesi']; ?></div>
	</div>

	<!--- MENU RESPONSIVE -->
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<!-- brand -->
		<a class="navbar-brand" href="#">
			<img src="images/logo-perpustakaan3.png" style="width:50px;padding-left:15px;" class="rounded-pill" />
		</a>

		<!-- TAMPIL DATA KOTAK / HUMBERGER  -->
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuapp">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<!-- MEMBUAT MENU  -->
		<div class="collapse navbar-collapse" id="menuapp">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=beranda">Beranda</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" id="navbardrop" data-bs-toggle="dropdown">Data MASTER</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="index.php?p=anggota">Data Anggota</a></li>
						<li><a class="dropdown-item" href="index.php?p=buku">Data Buku</a></li>
					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" id="navbardrop" data-bs-toggle="dropdown">Data Transaksi</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="index.php?p=pinjaman">Transaksi Peminjaman</a></li>
						<li><a class="dropdown-item" href="index.php?p=pengembalian">Transaksi Pengembalian</a></li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="index.php?p=laporan">Laporan Transaksi</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid p-0 bg-white">
		<?php
			if (isset($_GET['p'])) {
				getPage ($_GET['p']);	
			}else{
				getPage ('beranda');
			}
		?>
	</div>

	<div class="container-fluid p- bg-dark text-white">
		<p><h5>Sistem Informasi Perpustakaan (sipus) | Praktikum </h5></p>
		<p><h6><small>
		Kasus asli dari Kominfo & Panitia VSGA <br />
		Modifikasi oleh Stendy B. Sakur (Politeknik Negeri Nusa Utara) <br />
		Logmodif: menggunakan Bootsrap sederhana dan Mengubah Teknik Pemrograman dengan menggunakan konsep Subrutin / modular</small></h6></p>
	</div>
</body>
</html>