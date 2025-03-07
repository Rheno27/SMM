@extends('layouts.app')

@section('title', 'Data Tugas')

@section('content')
<!-- START DATA -->
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <!-- TOMBOL TAMBAH DATA -->
                    <div class="pb-3">
                    <a href='' class="btn btn-primary tombol-tambah">+ Tambah Data</a>
                    </div>
                    <table class="table table-striped" id="tugas-table">
                        <thead>
                            <tr>
                                <th class="col-md-1">No</th>
                                <th class="col-md-1">Nama Tugas</th>
                                <th class="col-md-1">Deskripsi</th>
                                <th class="col-md-1">Tanggal Pemberian Tugas</th>
                                <th class="col-md-1">Tanggal Pengumpulan</th>
                                <th class="col-md-1">Status</th>
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
                                <label for="nama_tugas" class="col-sm-2 col-form-label">Nama Tugas</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='nama_tugas' id="nama_tugas">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='deskripsi' id="deskripsi">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_pemberian_tugas" class="col-sm-2 col-form-label">Tanggal Pemberian Tugas</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name='tanggal_pemberian_tugas' id="tanggal_pemberian_tugas">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_pengumpulan" class="col-sm-2 col-form-label">Tanggal Pengumpulan</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name='tanggal_pengumpulan' id="tanggal_pengumpulan">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='status' id="status">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="mahasiswa_id" class="col-sm-2 col-form-label">Mahasiswa ID</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name='mahasiswa_id' id="mahasiswa_id">
                                </div>
                            </div>
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
        @include('tugas.script')
@endsection
