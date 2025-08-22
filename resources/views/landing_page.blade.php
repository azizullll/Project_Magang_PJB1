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
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Navbar */
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

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            background: url("{{ asset('images/Hero-section.png') }}") no-repeat center center;
            background-size: cover;
            padding-top: 60px;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0d47a1;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
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
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        /* Modal login */
        .modal-title {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="#">SkillPath</a>
            <!-- Tombol untuk membuka modal login -->
            <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text -->
                <div class="col-md-6 hero-text">
                    <h1>Temukan Pelatihan <br> Terbaik untuk Anda</h1>
                    <p>
                        Platform pencarian pelatihan yang membantu karyawan 
                        menemukan pelatihan terbaik, sesuai, dan siap pengembangan diri.
                    </p>
                    <a href="{{ url('/cek-kompetensi') }}" class="btn btn-primary mt-3">Mulai Sekarang</a>
                </div>

                <!-- Illustration -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/orangpanah.png') }}" alt="Ilustrasi" class="illustration img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Login -->
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
                            <input type="email" class="form-control rounded-pill" id="email" placeholder="Masukkan email">
                        </div>
                        <div class="mb-3 position-relative w-100">
                            <input type="password" class="form-control rounded-pill pe-5" 
                                id="password" placeholder="Masukkan password">
                            <button type="button" id="togglePassword" 
                                class="btn btn-link position-absolute top-50 end-0 translate-middle-y pe-3"
                                style="border: none; background: none;">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle show/hide password
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
