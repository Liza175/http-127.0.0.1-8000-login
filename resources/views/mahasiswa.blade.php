@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Mahasiswa</h3>
    <button class="btn btn-primary mb-3" id="btn-tambah">Tambah Mahasiswa</button>

    <table class="table table-bordered" id="table-mahasiswa">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Jurusan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAddLabel">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-mahasiswa">
            @csrf
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan NIM">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama">
            </div>
            <div class="mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <select name="jurusan" id="jurusan" class="form-control" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Teknik Elektro">Teknik Elektro</option>
                    <option value="Teknik Sipil">Teknik Sipil</option>
                    <option value="Akuntansi">Akuntansi</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Masukkan Alamat"></textarea>
            </div>
            <input type="hidden" id="edit_nim" name="edit_nim">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
        <button type="button" class="btn btn-primary" id="btn-update" style="display: none;">Edit Data</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    var table;

    $(document).ready(function() {
        // Inisialisasi datatable
       table = $('#table-mahasiswa').DataTable({
    ajax: {
        url: "/api/mahasiswa",
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: (data, type, row, meta) => meta.row + 1 },
        { data: 'nim' },
        { data: 'nama' },
        { data: 'jk' },
        { data: 'tgl_lahir' },
        { data: 'jurusan' },
        { data: 'alamat' },
        {
            data: 'nim',
            render: function(nim) {
                return `
                    <button class="btn btn-warning btn-sm btn-edit" data-id="${nim}">Edit</button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="${nim}">Hapus</button>`;
            }
        }
    ]
});


        // Reset form saat tambah data
        $('#btn-tambah').click(function() {
            $('#ModalAddLabel').text('Tambah Mahasiswa');
            $('#form-mahasiswa')[0].reset();
            $('#nim').prop('readonly', false); // Boleh diketik saat tambah
            $('#btn-simpan').show();
            $('#btn-update').hide();
            $('#ModalAdd').modal('show');
        });

        // Ambil data dari form
        function ambildataForm() {
            return {
                nim: $('#nim').val(),
                nama: $('#nama').val(),
                jk: $('#jk').val(),
                tgl_lahir: $('#tgl_lahir').val(),
                jurusan: $('#jurusan').val(),
                alamat: $('#alamat').val()
            };
        }

        // Simpan data baru
        $('#btn-simpan').click(function() {
            var data = ambildataForm();

            $.ajax({
                url: '/api/mahasiswa',
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#ModalAdd').modal('hide');
                    table.ajax.reload();
                    alert('Data berhasil disimpan');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Ambil data untuk diedit (gunakan GET, bukan PUT!)
            $('#table-mahasiswa').on('click', '.btn-edit', function() {
        var nim = $(this).data('id'); 
        $.ajax({
            url: '/api/mahasiswa/' + nim,
            type: 'GET',
            success: function(data) {
                $('#ModalAddLabel').text('Edit Mahasiswa');
                $('#ModalAdd').modal('show');
                $('#nim').val(data.data.nim).prop('readonly', true);
                $('#nama').val(data.data.nama);
                $('#jk').val(data.data.jk);
                $('#tgl_lahir').val(data.data.tgl_lahir);
                $('#jurusan').val(data.data.jurusan);
                $('#alamat').val(data.data.alamat);
                $('#edit_nim').val(data.data.nim);

                // Tampilkan tombol edit
                $('#btn-simpan').hide();
                $('#btn-update').show();

                // Tampilkan modal
                $('#ModalAdd').modal('show');
            },
            error: function(xhr) {
                alert('Gagal ambil data: ' + xhr.responseText);
            }
        });
    });


        // Update data mahasiswa
        $('#btn-update').click(function() {
            var nim = $('#edit_nim').val();
            var data = ambildataForm();

            $.ajax({
                url: '/api/mahasiswa/' + nim,
                type: 'PUT',
                data: data,
                success: function(response) {
                    $('#ModalAdd').modal('hide');
                    table.ajax.reload();
                    alert('Data berhasil diupdate');
                },
                error: function(xhr) {
                    alert('Gagal update: ' + xhr.responseText);
                }
            });
        });

        // Hapus data mahasiswa
        $('#table-mahasiswa').on('click', '.btn-delete', function() {
            var nim = $(this).data('id');
            if (confirm('Yakin ingin menghapus mahasiswa ini?')) {
                $.ajax({
                    url: '/api/mahasiswa/' + nim,
                    type: 'DELETE',
                    success: function(response) {
                        table.ajax.reload();
                        alert('Data berhasil dihapus');
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus: ' + xhr.responseText);
                    }
                });
            }
        });


    });
</script>
@endsection