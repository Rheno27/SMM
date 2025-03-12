<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
    // Tampilkan Data Tugas
    $(document).ready(function() {
        $('#tugas-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ url('api/tugas') }}",
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
                { data: 'nama_tugas', name: 'nama_tugas' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'tanggal_pemberian_tugas', name: 'tanggal_pemberian_tugas', render: function(data) {
                    return new Date(data).toLocaleDateString('id-ID');
                }},
                { data: 'tanggal_pengumpulan', name: 'tanggal_pengumpulan', render: function(data) {
                    return new Date(data).toLocaleDateString('id-ID');
                }},
                { data: 'status', 
                    render: function(data) {
                        if (data === 'Belum Selesai') {
                            return '<span class="badge bg-danger">Belum Selesai</span>';
                        } else if (data === 'Selesai') {
                            return '<span class="badge bg-success">Selesai</span>';
                        } else {
                            return '<span class="badge bg-warning">Belum Selesai</span>';
                        }
                    }
                },
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

    // Tambah Data Tugas
    $(document).ready(function() {
        let user = JSON.parse(localStorage.getItem('user')); // Ambil data user dari local storage
        let token = localStorage.getItem('token'); // Ambil token untuk autentikasi

        if (!user || !token) {
            alert("Anda harus login terlebih dahulu!");
            window.location.href = "/login"; // Redirect ke halaman login jika belum login
            return;
        }

        $('body').on('click', '.tombol-tambah', function(e) {
            e.preventDefault();
            $('#modal-tambah').modal('show');
        });

        $('#form-tambah').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                nama_tugas: $('#nama_tugas').val(),
                deskripsi: $('#deskripsi').val(),
                tanggal_pemberian_tugas: $('#tanggal_pemberian_tugas').val(),
                tanggal_pengumpulan: $('#tanggal_pengumpulan').val(),
                status: $('#status').val(),
                mahasiswa_id: user.id // Ambil mahasiswa_id dari user yang login
            };
            console.log("Data yang akan dikirim ke API (POST):", formData);

            $.ajax({
                url: "{{ url('api/tugas') }}", // Sesuaikan dengan API endpoint
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + token, // Pakai token dari local storage
                },
                success: function(response) {
                    console.log(response);
                    alert("Tugas berhasil ditambahkan!");
                    $('#tugas-table').DataTable().ajax.reload();
                    $('#modal-tambah').modal('hide');
                    $('#form-tambah')[0].reset();
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText, );
                    console.log("Error tambah tugas: ", xhr.responseText);
                }
            });
        });
    });


    // Hapus Data Tugas
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
                url: "{{ url('api/tugas') }}/" + id,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#tugas-table').DataTable().ajax.reload();
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

    // Edit Data Tugas
    $(document).ready(function() {
        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));
        if (!token) {
            alert("User tidak ditemukan atau belum login.");    
            return;
        }
        $('body').on('click', '#btn-edit', function(e) {
            e.preventDefault();
            let tugasId = $(this).data('id');
            console.log("ID Tugas: ", tugasId);
            $('#modal-edit').modal('show');

            $.ajax({
                url: "{{ url('api/tugas') }}/" + tugasId,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {

                    console.log("Response API: ", response);

                    let tugas = response.data;
                    if(user.id !== tugas.mahasiswa_id) {
                        $('#modal-edit').modal('hide');
                        alert("Anda tidak diperbolehkan mengedit tugas ini.");

                        return;
                    }
                    if (tugas) {
                        $('#edit_nama_tugas').val(tugas.nama_tugas || '');
                        $('#edit_deskripsi').val(tugas.deskripsi || '');
                        $('#edit_tanggal_pemberian_tugas').val(tugas.tanggal_pemberian_tugas || '');
                        $('#edit_tanggal_pengumpulan').val(tugas.tanggal_pengumpulan || '');
                        $('#edit_status').val(tugas.status || '');
                        
                        $('#form-edit').attr('data-id', tugasId);
                    } else {
                        alert("Data tugas tidak ditemukan!");
                    }
                },
                error: function(xhr) {
                    alert("Gagal mengambil data tugas.");
                    console.log("Error: ", xhr.responseText);
                }
            });
        });
    });

    $(document).on('submit', '#form-edit', function(e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        if (!token) {
            alert("User tidak ditemukan atau belum login.");
            return;
        }

        let tugasId = $(this).attr('data-id');
        console.log("ID Tugas yang akan diubah: ", tugasId);

        let updateData = {
            nama_tugas: $('#edit_nama_tugas').val().trim(),
            deskripsi: $('#edit_deskripsi').val().trim(),
            tanggal_pemberian_tugas: $('#edit_tanggal_pemberian_tugas').val().trim(),
            tanggal_pengumpulan: $('#edit_tanggal_pengumpulan').val().trim(),
            status: $('#edit_status').val().trim()
        };

        console.log("Data yang akan dikirim ke API (PUT):", updateData);

        $.ajax({
            url: "{{ url('api/tugas') }}/" + tugasId,
            type: 'PUT',
            contentType: "application/json",
            data: JSON.stringify(updateData),
            headers: {
                'Authorization': 'Bearer ' + token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log("Response API: ", response);
                alert("Tugas berhasil diperbarui!");
                $('#modal-edit').modal('hide');
                $('#tugas-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert("Gagal memperbarui tugas.");
                console.log("Error memperbarui tugas: ", xhr.responseText);
            }
        });
    });
</script>

