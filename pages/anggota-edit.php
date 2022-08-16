<?php  
require_once "modul/modul.php"; 
extract(getUserForUpdate($_GET));
?>

<div class="container-fluid p-3">
	<h3>Edit Data Anggota</h3>
</div>
<div class="container-fluid">
	<form action="proses/proses.php" method="post" enctype="multipart/form-data" class="was-validated">
	
	<!---- Menggunakan DIV --->
	<div class="form-group">
		<img src="foto/<?php echo $foto; ?>" class="rounded-circle" width=70px height=75px>
		<hr class="my-4">
		<label for="foto">Pilih Foto yang akan dipakai:</label>
		<br />
		<input type="file" name="foto">
		<input type="hidden" name="foto_awal" value="<?php echo $foto; ?>">
	</div>

	<div class="form-group">
		<label for="id_anggota">ID Anggota:</label>
		<input type="text" name="id_anggota" value="<?php echo $id_anggota; ?>" readonly="readonly" class="form-control form-control-sm" required>
		<div class="valid-feedback">Benar.</div>
		<div class="invalid-feedback">Mohon data ini disi dahulu</div>
	</div>

	<div class="form-group">
		<label for="nama">Nama Anggota: </label>
		<input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" class="form-control form-control-sm" required>
		<div class="valid-feedback">Benar.</div>
		<div class="invalid-feedback">Mohon data ini disi dahulu</div>
	</div>

	<div class="form-group">
		<label>Jenis Kelamin: </label><br />
		<div class="form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria" <?= checkJenisKelamin("Pria"); ?>>Pria
			</label>	
		</div>
	
		<div class="form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita" 
				<?php if ($jeniskelamin == "Wanita") { ?>
					checked
				<?php } ?>
				>Wanita	
			</label>	
		</div>
	</div>

	<div class="form-group">
		<label for="alamat">Alamat: </label>
		<textarea rows="2" id="alamat" name="alamat" class="form-control form-control-sm" required><?php echo $alamat; ?></textarea>
		<div class="valid-feedback">Benar.</div>
		<div class="invalid-feedback">Mohon data ini disi dahulu</div>
	</div>
	
	<div class="form-group">
		<input type="hidden" name="page" value="<?php echo $page; ?>" id="page">
		<input type="submit" name="submit" value="update" id="tombol-simpan" class="btn btn-primary" />
	</div>
	<hr class="my-5">
	</form>
</div>