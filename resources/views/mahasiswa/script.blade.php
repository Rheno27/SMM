<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
    function formatDate(dateString) {
        let date = new Date(dateString);
        let yyyy = date.getFullYear();
        let mm = String(date.getMonth() + 1).padStart(2, '0'); // Bulan mulai dari 0
        let dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`; // Format sesuai input date
    }

    $(document).ready(function() {
        $('#mahasiswa-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ url('api/mahasiswa') }}",
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
                { data: 'nama', name: 'nama' },
                { data: 'nim', name: 'nim' },
                { data: 'email', name: 'email' },
                { data: 'prodi', name: 'prodi' },
                { data: 'tanggal_lahir', name: 'tanggal_lahir', render: function(data) {
                    return new Date(data).toLocaleDateString('id-ID');
                }},
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <button id="btn-lihat" class="btn btn-primary btn-sm" >Lihat lengkap</button>
                        `;
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

    // Tambah Data Mahasiswa
    $(document).ready(function() {
        // Tampilkan Modal Tambah
        $('body').on('click', '.tombol-tambah', function(e) {
            e.preventDefault();
            $('#modal-tambah').modal('show');
        });

        // Simpan Data Mahasiswa
        $('#btn-simpan').on('click', function(e) {
            e.preventDefault();
            let token = localStorage.getItem('token');

            let formData = new FormData();
            formData.append("nama", $('#nama').val());
            formData.append("nim", $('#nim').val());
            formData.append("email", $('#email').val());
            formData.append("prodi", $('#prodi').val());
            formData.append("foto", $('#foto')[0].files[0]); // Ambil file dari input
            formData.append("alamat", $('#alamat').val());
            formData.append("no_hp", $('#no_hp').val());
            formData.append("tanggal_lahir", $('#tanggal_lahir').val());
            formData.append("jenis_kelamin", $('#jenis_kelamin').val());
            formData.append("password", $('#password').val());
            formData.append("password_confirmation", $('#password_confirmation').val());

            // Cek Password dan Konfirmasi
            if ($('#password').val() !== $('#password_confirmation').val()) {
                alert("Password dan Password Confirmation tidak sama!");
                return;
            }

            // Debugging: Cek apakah FormData sudah terisi
            console.log("Cek FormData sebelum dikirim:");
            for (let pair of formData.entries()) {
                console.log(pair[0]+ ': ' + pair[1]);
            }

            $.ajax({
                url: "/api/mahasiswa", // Gunakan URL yang benar
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                },
                success: function(response) {
                    alert("Registrasi berhasil! Silakan login.");
                    $('#modal-tambah').modal('hide'); // Tutup modal
                    window.location.href = "/login"; // Redirect ke login setelah berhasil
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText);
                    alert("Gagal melakukan registrasi! Cek kembali data yang diinput.");
                }
            });
        });
    });


    // Hapus Data Mahasiswa
    $(document).ready(function() {
        let user = JSON.parse(localStorage.getItem('user'));
        let token = localStorage.getItem('token');
        
        $('body').on('click', '#btn-hapus', function(e) {
            e.preventDefault();
            $('#modal-delete').modal('show');
        });
    });

    // Edit Data Mahasiswa
    $(document).ready(function() {
        let token = localStorage.getItem('token');
        let user = JSON.parse(localStorage.getItem('user'));
        if (!token) {
            alert("User tidak ditemukan atau belum login.");
            return;
        }
        $('body').on('click', '#btn-edit', function(e) {
            e.preventDefault();
            let mahasiswaId = $(this).data('id');
            console.log("ID Mahasiswa: ", mahasiswaId);
            $('#modal-edit').modal('show');

            $.ajax({
                url: "{{ url('api/mahasiswa') }}/" + mahasiswaId,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    console.log("Response API: ", response);

                    let mahasiswa = response.data;
                    if (user.id !== mahasiswa.id) {
                        $('#modal-edit').modal('hide');
                        alert("Anda tidak diperbolehkan mengedit data ini.");

                        return;
                    }
                    if (mahasiswa) {
                        $('#edit_nama').val(mahasiswa.nama || '');  
                        $('#edit_nim').val(mahasiswa.nim || '');    
                        $('#edit_email').val(mahasiswa.email || '');
                        $('#edit_prodi').val(mahasiswa.prodi || '');
                        $('#edit_alamat').val(mahasiswa.alamat || '');
                        $('#edit_no_hp').val(mahasiswa.no_hp || '');
                        $('#edit_tanggal_lahir').val(formatDate(mahasiswa.tanggal_lahir));
                        $('#edit_jenis_kelamin').val(mahasiswa.jenis_kelamin || '');

                        let fullFotoUrl = mahasiswa.foto ? `{{url('storage')}}/${mahasiswa.foto}` : "default-avatar.png";
                        $('#edit_foto_preview').attr('src', fullFotoUrl);

                        $('#form-edit').attr('data-id', mahasiswaId);
                    } else {
                        alert("Data mahasiswa tidak ditemukan!");
                    }
                },
                error: function(xhr) {
                    alert("Gagal mengambil data mahasiswa.");
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

        let mahasiswaId = $(this).attr('data-id');
        console.log("ID Mahasiswa yang akan diubah: ", mahasiswaId);
        
        let updateData = {
            nama: $('#edit_nama').val().trim(),
            nim: $('#edit_nim').val().trim(),
            email: $('#edit_email').val().trim(),
            prodi: $('#edit_prodi').val().trim(),
            foto: $('#edit_foto').val().trim(),
            alamat: $('#edit_alamat').val().trim(),
            no_hp: $('#edit_no_hp').val().trim(),
            tanggal_lahir: $('#edit_tanggal_lahir').val().trim(),
            jenis_kelamin: $('#edit_jenis_kelamin').val().trim()
        };

        console.log("Data yang akan dikirim ke API (PUT):", updateData);

        $.ajax({
            url: "{{ url('api/mahasiswa') }}/" + mahasiswaId,
            type: 'PUT',
            contentType: "application/json",
            data: JSON.stringify(updateData),
            headers: {
                'Authorization': 'Bearer ' + token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log("Response API: ", response);
                alert("Data mahasiswa berhasil diperbarui!");
                $('#modal-edit').modal('hide');
                $('#mahasiswa-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert("Gagal memperbarui data mahasiswa.");
                console.log("Error memperbarui data mahasiswa: ", xhr.responseText);
            }
        });
    });
</script>