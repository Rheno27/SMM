<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
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
                            <button id="btn-edit" class="btn btn-warning btn-sm" >Edit</button>
                            <button id="btn-hapus" class="btn btn-danger btn-sm" >Hapus</button>
                        `;
                    }
                }
            ]
        });
    });
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
    $('body').on('click', '#btn-hapus', function(e) {
        e.preventDefault();
        $('#modal-delete').modal('show');
    });
</script>