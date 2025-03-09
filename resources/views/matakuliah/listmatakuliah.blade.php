@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
<!-- START DATA -->
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <!-- TOMBOL TAMBAH DATA -->
                    <div class="pb-3">
                    <a href='' class="btn btn-primary tombol-tambah">+ Tambah Data</a>
                    </div>
                    <table class="table table-striped" id="matakuliah-table">
                        <thead>
                            <tr>
                                <th class="col-md-1">No</th>
                                <th class="col-md-1">Nama Mata Kuliah</th>
                                <th class="col-md-1">Kode Mata Kuliah</th>
                                <th class="col-md-1">SKS</th>
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
                                <label for="nama_mata_kuliah" class="col-sm-2 col-form-label">Nama Mata Kuliah</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='nama' id="nama">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="kode_mata_kuliah" class="col-sm-2 col-form-label">Kode Mata Kuliah</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='kode_mata_kuliah' id="kode_mata_kuliah">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="sks" class="col-sm-2 col-form-label">SKS</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name='sks' id="sks">
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
        <!--DELETE MATKUL MODAL -->
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tombol-batal">Batal</button>
                        <button type="button" class="btn btn-danger tombol-hapus">Hapus</button>
                    </div>
                </div>  
            </div>
        </div>
        <!-- AKHIR DELETE MATKUL MODAL -->
        

        @include('matakuliah.script')
@endsection
