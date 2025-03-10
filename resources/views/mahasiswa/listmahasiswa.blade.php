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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="btn-simpan" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
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
