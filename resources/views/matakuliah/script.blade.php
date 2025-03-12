<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
    // Tampilkan Data Matakuliah
    $(document).ready(function() {
        $('#matakuliah-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ url('api/matakuliah') }}",
                type: 'GET',
                dataType: 'json',
                dataSrc: function(json) {
                    return json.data;
                }
            },
            columns: [
                { data: null, render: function(data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'nama_mata_kuliah', name: 'nama_mata_kuliah' },
                { data: 'kode_mata_kuliah', name: 'kode_mata_kuliah' },
                { data: 'sks', name: 'sks' },
                { 
                    data: 'id',
                    render: function(data) {
                        return `
                            <button id="btn-edit" class="btn btn-warning btn-sm" data-id="${data}">Edit</button>
                            <button id="btn-hapus" class="btn btn-danger btn-sm" data-id="${data}">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });

    $(document).ready(function() {
        let user = JSON.parse(localStorage.getItem('user'));
        let token = localStorage.getItem('token');
        
        if (!user || !token) {
            alert("Anda harus login terlebih dahulu!");
            window.location.href = "/login";
            return;
        }

        $('body').on('click', '.tombol-tambah', function(e) {
            e.preventDefault();
            $('#modal-tambah').modal('show');
        });

        $('#form-tambah').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                nama_mata_kuliah: $('#nama_mata_kuliah').val(),
                kode_mata_kuliah: $('#kode_mata_kuliah').val(),
                sks: $('#sks').val(),
            };

            $.ajax({
                url: "{{ url('api/matakuliah') }}",
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(response) {
                    console.log(response);
                    alert("Matakuliah berhasil ditambahkan!");
                    
                    if ($.fn.DataTable.isDataTable('#matakuliah-table')) {
                        $('#matakuliah-table').DataTable().ajax.reload();
                    }

                    $('#modal-tambah').modal('hide');
                    $('#form-tambah')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Gagal menambahkan matakuliah!");
                }
            });
        });
    });


    // Hapus Data Matakuliah
    $('body').on('click', '#btn-hapus', function(e) {
        e.preventDefault();
        $('#modal-delete').modal('show');

        var id = $(this).data('id');

        if (!id) {
            alert("ID tidak ditemukan!");
            return;
        }
        
        $('#modal-delete').off('click').on('click', '.tombol-hapus', function(e) {
            e.preventDefault();
            $.ajax({
                url: "/api/matakuliah/" + id,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#matakuliah-table').DataTable().ajax.reload();
                    console.log(response);
                    $('#modal-delete').modal('hide');
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText, );
                    console.log(xhr.responseText);
                }
            });
        });
    });

    // Edit Data Matakuliah
    $(document).ready(function() {
        let token = localStorage.getItem('token');
        
        if (!token) {
            alert("User tidak ditemukan atau belum login.");    
            return;
        }

        $('body').on('click', '#btn-edit', function(e) {
            e.preventDefault();

            let matakuliahId = $(this).data('id');
            console.log("ID Matakuliah: ", matakuliahId);
            $('#modal-edit').modal('show');

            $.ajax({
                url: "/api/matakuliah/" + matakuliahId,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log("Response API: ", response);

                    let matakuliah = response.data;
                    if (matakuliah) {
                        $('#edit_nama_mata_kuliah').val(matakuliah.nama_mata_kuliah || '');
                        $('#edit_kode_mata_kuliah').val(matakuliah.kode_mata_kuliah || '');
                        $('#edit_sks').val(matakuliah.sks || '');

                        $('#form-edit').attr('data-id', matakuliahId);
                    } else {
                        alert("Data matakuliah tidak ditemukan!");
                    }
                },
                error: function(xhr) {
                    alert("Gagal mengambil data matakuliah.");
                    console.log("Error: ", xhr.responseText);
                }
            })
        });
    });

    $(document).on('submit', '#form-edit', function(e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            alert("User tidak ditemukan atau belum login.");
            return;
        }

        let matakuliahId = $(this).attr('data-id');
        console.log("ID Matakuliah yang akan diubah: ", matakuliahId);

        let updateData = {
            nama_mata_kuliah: $('#edit_nama_mata_kuliah').val().trim(),
            kode_mata_kuliah: $('#edit_kode_mata_kuliah').val().trim(),
            sks: $('#edit_sks').val().trim()
        };

        console.log("Data yang akan dikirim ke API (PUT):", updateData);

        $.ajax({
            url: "/api/matakuliah/" + matakuliahId,
            type: 'PUT',
            contentType: "application/json",
            data: JSON.stringify(updateData),
            headers: {
                'Authorization': 'Bearer ' + token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log("Response API:", response);
                alert("Data matakuliah berhasil diperbarui!");
                $('#modal-edit').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                console.error("Terjadi kesalahan:", xhr.responseText);
                alert("Terjadi kesalahan: " + (xhr.responseJSON ? xhr.responseJSON.message : "Gagal memperbarui matakuliah."));
            }
        });
    });


</script>