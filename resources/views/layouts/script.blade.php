<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let user = JSON.parse(localStorage.getItem('user'));
        let token = localStorage.getItem('token');

        if (!user || !token) {
            alert("Anda harus login terlebih dahulu!"); 
            window.location.href = "/login";
            return;
        }

        let id = user.id; 
        
        $.ajax({
            url: `{{url('api/mahasiswa')}}/${id}`, 
            type: "GET",
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(response) {

                let nama = response.data.nama;
                let fotoPath = response.data.foto;

                $("#user-name").text(nama);

                let fullFotoUrl = fotoPath ? `{{url('storage')}}/${fotoPath}` : "default-avatar.png";
                $("#user-photo").attr("src", fullFotoUrl);
            },
            error: function(xhr, status, error) {
                $("#user-name").text("Guest");
                $("#user-photo").attr("src", "default-avatar.png");
            }
        });
    }); 
</script>
