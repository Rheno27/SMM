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

    // Tambah Data Matakuliah
    $('body').on('click', '.tombol-tambah', function(e) {
        e.preventDefault();
        $('#modal-tambah').modal('show');

        $('.tombol-simpan').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('api/matakuliah') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
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