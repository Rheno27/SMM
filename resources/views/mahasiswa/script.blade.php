<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
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
    $('body').on('click', '.tombol-tambah', function(e) {
        e.preventDefault();
        $('#modal-tambah').modal('show');

        $('.tombol-simpan').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('api/mahasiswa') }}",
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