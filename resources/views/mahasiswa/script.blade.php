<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
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
                            <button id="btn-edit" class="btn btn-warning btn-sm" >Edit</button>
                            <button id="btn-hapus" class="btn btn-danger btn-sm" >Hapus</button>
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

    $(document).ready(function() {
        let user = JSON.parse(localStorage.getItem('user'));
        let token = localStorage.getItem('token');

        if (!user || !user.id || !token) {
            alert("User tidak ditemukan atau belum login.");
            return;
        }

        $('body').on('click', '#btn-edit', function(e) {
            e.preventDefault();
            let mahasiswaId = $(this).data('id');
            console.log("ID Mahasiswa: ", mahasiswaId);
            $('#modal-edit').modal('show');

            $.ajax({
                url: "/api/mahasiswa/" + mahasiswaId,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    $('#edit_nama').val(response.nama);
                    $('#edit_nim').val(response.nim);
                    $('#edit_email').val(response.email);
                    $('#edit_prodi').val(response.prodi);
                    $('#edit_alamat').val(response.alamat);
                    $('#edit_no_hp').val(response.no_hp);
                    $('#edit_tanggal_lahir').val(response.tanggal_lahir);
                    $('#edit_jenis_kelamin').val(response.jenis_kelamin);
                    $('#modal-edit').modal('show');
                },
                error: function() {
                    alert("Gagal mengambil data mahasiswa.");
                }
            });
        });

        // Simpan perubahan data mahasiswa
        $('#btn-simpan').on('click', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append("nama", $('#edit_nama').val());
            formData.append("nim", $('#edit_nim').val());
            formData.append("email", $('#edit_email').val());
            formData.append("prodi", $('#edit_prodi').val());
            formData.append("alamat", $('#edit_alamat').val());
            formData.append("no_hp", $('#edit_no_hp').val());
            formData.append("tanggal_lahir", $('#edit_tanggal_lahir').val());
            formData.append("jenis_kelamin", $('#edit_jenis_kelamin').val());

            // Cek apakah user ingin mengganti password
            let password = $('#edit_password').val();
            let password_confirmation = $('#edit_password_confirmation').val();
            if (password) {
                formData.append("password", password);
                formData.append("password_confirmation", password_confirmation);
            }

            // Cek apakah ada file foto yang dipilih
            let foto = $('#edit_foto')[0].files[0];
            if (foto) {
                formData.append("foto", foto);
            }

            $.ajax({
                url: "/api/mahasiswa/" + mahasiswaId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    alert("Data berhasil diubah!");
                    $('#modal-edit').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseJSON.message);
                }
            });
        });
    });

</script>