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
        <!-- START MODAL -->
        <div class="modal" tabindex="-1" id="modal-tambah">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- START FORM -->
                        <form id='form-tambah'>
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='nama' id="nama">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='nim' id="nim">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='email' id="email">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='prodi' id="prodi">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='no_hp' id="no_hp">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name='tanggal_lahir' id="tanggal_lahir">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='jenis_kelamin' id="jenis_kelamin">
                                </div>
                            </div>                            
                        </form>
                    <!-- AKHIR FORM -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button  type="submit" class="btn btn-primary tombol-simpan">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        <!-- AKHIR MODAL -->
        @include('mahasiswa.script')
@endsection
