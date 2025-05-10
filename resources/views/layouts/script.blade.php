<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let user = JSON.parse(localStorage.getItem('user'));
        let token = localStorage.getItem('token');

        if (!user || !token) {
            alert("Anda harus login terlebih dahulu!");
            window.location.href = "/login";
            return;
        }

        let id = user.id;

        // base path untuk gambar
        let baseUrl = "{{ url('storage/mahasiswa_foto') }}";

        $.ajax({
            url: `/api/mahasiswa/${id}`,
            type: "GET",
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function (response) {
                let nama = response.data.nama;
                let fotoPath = response.data.foto;

                // Set nama user
                $("#user-name").text(nama);

                // Pastikan fotoPath hanya nama file (tanpa folder)
                let fullFotoUrl = fotoPath ? `${baseUrl}/${fotoPath}` : "profile_default.png";

                // Tampilkan foto
                $("#user-photo").attr("src", fullFotoUrl);
            },
            error: function () {
                $("#user-name").text("Guest");
                $("#user-photo").attr("src", "profile_default.png");
            }
        });
    });
</script>



    $(document).ready(function() {
        $('#logout').click(function() {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            window.location.href = "/login";
        });
    });

</script>
</script>
