<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillPath - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body,
        html {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .navbar {
            background-color: #0d47a1 !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }

        .btn-login {
            background: white;
            color: #0d47a1;
            border-radius: 20px;
            padding: 6px 18px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #ffc107;
            color: #0d47a1;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            background: url("{{ asset('images/Hero-section.png') }}") no-repeat center center;
            background-size: cover;
            overflow: hidden;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0d47a1;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .hero-text p {
            color: #555;
            margin-top: 15px;
            font-size: 1.05rem;
        }

        .btn-primary {
            background-color: #0d47a1;
            border: none;
            border-radius: 25px;
            padding: 12px 28px;
            font-weight: 600;
            box-shadow: 0px 4px 12px rgba(13, 71, 161, 0.3);
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #1565c0;
            transform: translateY(-3px);
        }

        .illustration {
            width: 500px;
            max-width: 100%;
            animation: float 4s ease-in-out infinite;
        }

        .toggle-password-btn {
            border: none;
            background: transparent;
            padding: 0;
            position: absolute;
            right: 12px;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .toggle-password-btn i {
            font-size: 1.2rem;
            color: #555;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .modal-title {
            width: 100%;
            text-align: center;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="#">SkillPath</a>
            <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text">
                    <h1>Temukan Pelatihan <br> Terbaik untuk Anda</h1>
                    <p>
                        Platform pencarian pelatihan yang membantu karyawan
                        menemukan pelatihan terbaik, sesuai, dan siap pengembangan diri.
                    </p>
                    <a href="{{ url('/cek-kompetensi') }}" class="btn btn-primary mt-3">Mulai Sekarang</a>
                </div>

                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/orangpanah.png') }}" alt="Ilustrasi" class="illustration img-fluid">
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 rounded-4 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control rounded-pill" id="email"
                                placeholder="Masukkan email">
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control rounded-pill pe-5" id="password"
                                    placeholder="Masukkan password">

                                <button type="button" id="togglePassword"
                                    class="position-absolute top-50 end-0 translate-middle-y pe-3"
                                    style="border: none; background: none; padding: 0;">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle show/hide password
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            this.querySelector("i").classList.toggle("bi-eye");
            this.querySelector("i").classList.toggle("bi-eye-slash");
        });
    </script>
</body>

</html>
