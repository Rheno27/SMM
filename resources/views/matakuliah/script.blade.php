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
                            <button id="btn-edit" class="btn btn-warning btn-sm">Edit</button>
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

</script>