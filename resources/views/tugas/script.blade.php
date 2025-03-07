<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
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
                url: "{{ url('api/tugas') }}",
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
</script>