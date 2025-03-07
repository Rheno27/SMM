<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body class="text-center">
        <header>
            <!-- place navbar here -->
        </header>
        <main class="form-signin">
            <form id="loginForm">
                <img class="mb-4" src="{{ asset('brand/bootstrap-logo.svg') }}" alt="" width="72" height="57">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <p id="error-message" class="text-danger mt-2"></p>
            </form>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

        <!-- AJAX jQuery untuk Login -->
        <script>
            $(document).ready(function () {
                $('#loginForm').submit(function (event) {
                    event.preventDefault(); // Mencegah reload halaman

                    $.ajax({
                        url: "/api/login",
                        type: "POST",
                        contentType: "application/json",
                        dataType: "json",
                        headers: { "Accept": "application/json" },
                        data: JSON.stringify({
                            email: $('#email').val(),
                            password: $('#password').val()
                        }),
                        success: function (response) {
                            console.log("Full Response dari server:", response); // Debugging
                            let token = response.token; // Sekarang token langsung ada di response
                            console.log("Token yang digunakan:", token);

                            if (token) {
                                localStorage.setItem("token", token);
                                window.location.href = "/mahasiswa";
                            } else {
                                console.error("Token tidak ditemukan di response!");
                            }
                        },
                        error: function (xhr) {
                            $('#error-message').text(xhr.responseJSON?.message || "Login gagal!");
                        }
                    });

                });
            });

        </script>
    </body>
</html>
