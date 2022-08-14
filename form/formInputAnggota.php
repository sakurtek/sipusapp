<!-- MODAL: FORMINPUTANGGOTA -->
<div class="modal fade" id="FormInputAnggota">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- modal header -->
            <div class="modal-header">
                <h4 class="modal-title">Form Pengisian Data Anggota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="proses/proses.php" method="post" enctype="multipart/form-data" class="was-validated">
                <!-- modal body -->
                <div class="modal-body modal-body-sm">
                    <!-- element foto -->
		            <div class="mb-3">
			            <label for="foto" class="form-label">Foto Anggota</label>
			            <input type="file" name="foto" class="form-control-file form-control-sm border" id="foto" />
		            </div>
	
                    <div class="mb-0 mt-3">
                        <label for="id_anggota" class="form-label form-label-sm">ID Anggota</label>
                        <input type="text" name="id_anggota" class="form-control" id="id_anggota" placeholder="Masukkan ID Anggota" required>
					    <div class="valid-feedback">Benar.</div>
					    <div class="invalid-feedback">Mohon data ini disi dahulu</div>
                    </div>

                    <div class="mb-0 mt-3">   
                        <label for="nama" class="form-label form-label-sm">Nama Lengkap Anggota</label>  
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
				        <div class="valid-feedback">Benar.</div>
					    <div class="invalid-feedback">Mohon data ini disi dahulu</div>
                    </div>

                    <div class="mb-0 mt-3">
                        <div class="form-check-inline">
					        <label class="form-check-label">
						    <input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria" checked>Pria
					        </label>	
				        </div>
				        <div class="form-check-inline">
					        <label class="form-check-label">
					        <input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita">Wanita	
					        </label>	
				        </div>
                    </div>

                    <div class="mb-0 mt-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" rows="2" cols="40" name="alamat" id="alamat" required></textarea>
				        <div class="valid-feedback">Benar.</div>
				        <div class="invalid-feedback">Mohon data dilengkapi</div>
                    </div>
	            
                </div>

                <!-- form footer -->
                <div class="modal-footer">
                  <button type="submit" name="submit" value="simpan" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>