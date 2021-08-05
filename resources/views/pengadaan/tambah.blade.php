<div class="modal fade" id="pengadaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengadaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/tambahAdmin" method="post" role="form">
          {{csrf_field()}}
      <div class="modal-body">
      
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Pengadaan</label>
                    <input type="text" class="form-control" id="nama_pengadaan" name="nama_pengadaan" placeholder="Masukan Nama Pengadaan">
                  </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan deskripsi"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/png, image/jpg, image/gif">
                  </div>
                  <div class="form-group">
                    <!-- <label for="exampleInputEmail1">Anggaran</label> -->
                    <label>Anggaran: <input type="" class="labelRp" disable style="border:none; background-color: white; color: black;"></label>
                    <input type="text" class="form-control" id="anggaran" name="anggaran" placeholder="Masukan Anggaran" onkeyup="currency()">
                  </div>
                </div>
                <!-- /.card-body -->

             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
      </form>
    </div>
  </div>
</div>