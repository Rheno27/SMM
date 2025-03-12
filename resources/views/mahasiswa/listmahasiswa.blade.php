@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<!-- START DATA -->
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <!-- TOMBOL TAMBAH DATA -->
                    <div class="pb-3">
                    <a href='' class="btn btn-primary tombol-tambah">+ Tambah Data</a>
                    </div>
                    <table class="table table-striped" id="mahasiswa-table">
                        <thead>
                            <tr>
                                <th class="col-md-1">No</th>
                                <th class="col-md-1">Nama</th>
                                <th class="col-md-1">NIM</th>
                                <th class="col-md-1">Email</th>
                                <th class="col-md-1">Prodi</th>
                                <th class="col-md-1">Tanggal Lahir</th>
                                <th class="col-md-1">Detail</th>
                                <th class="col-md-2">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                
            </div>
            <!-- AKHIR DATA -->
        <!-- MODAL TAMBAH MAHASISWA -->
            <div class="modal fade" id="modal-tambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- FORM REGISTRASI -->
                            <form id="form-tambah">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" name="nim" id="nim" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Prodi</label>
                                    <input type="text" class="form-control" name="prodi" id="prodi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat">
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                </div>
                            </form>
                            <!-- AKHIR FORM -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary tombol-batal">Close</button>
                            <button type="submit" class="btn btn-primary tombol-simpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AKHIR MODAL -->
            <!-- START MODAL EDIT -->
            <div class="modal" tabindex="-1" id="modal-edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- START FORM -->
                            <form id="form-edit">                        
                                <div class="mb-3 row">
                                    <label for="edit_nama" class="col-sm-4 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_nama" id="edit_nama">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_nim" class="col-sm-4 col-form-label">NIM</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_nim" id="edit_nim">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_email" class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" name="edit_email" id="edit_email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_prodi" class="col-sm-4 col-form-label">Prodi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_prodi" id="edit_prodi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_alamat" class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_alamat" id="edit_alamat">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <img id="edit_foto_preview" src="" alt="Foto Mahasiswa" style="max-width: 100px;">
                                    <label for="edit_foto" class="col-sm-4 col-form-label">Foto</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" name="edit_foto" id="edit_foto">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_no_hp" class="col-sm-4 col-form-label">No HP</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="edit_no_hp" id="edit_no_hp">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="edit_tanggal_lahir" id="edit_tanggal_lahir">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="edit_jenis_kelamin" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="edit_jenis_kelamin" id="edit_jenis_kelamin">
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary tombol-batal">Batal</button>
                                    <button type="submit" class="btn btn-primary tombol-update">Update</button>
                                </div>
                            </form>
                            <!-- AKHIR FORM -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- AKHIR MODAL EDIT -->

            <!-- AKHIR MODAL -->

        <!--DELETE MAHASISWA MODAL -->
        <div class="modal" tabindex="-1" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- AKHIR DELETE MAHASISWA MODAL -->
        
        @include('mahasiswa.script')
@endsection
