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
            background: #ebe9e2;
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

        .form-control.is-valid,
        .was-validated .form-control:valid {
            border-color: #0d6efd !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: none !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .valid-feedback {
            color: #0d6efd !important;
            /* teks feedback juga jadi biru */
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="#">SkillPath</a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-login">Logout</button>
                </form>
            @else
                <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            @endauth
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

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 rounded-4 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="{{ route('login') }}" method="POST" novalidate>
                        @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill @error('email') is-invalid @enderror" id="email"
                                placeholder="Masukkan email" required value="{{ old('email') }}"
                                pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com|student\.polije\.ac\.id)$">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Email harus menggunakan @gmail.com / @yahoo.com / @outlook.com / @student.polije.ac.id</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="form-control rounded-pill pe-5 @error('password') is-invalid @enderror" id="password"
                                    placeholder="Masukkan password" required minlength="6">

                                <!-- Pesan validasi -->
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Password minimal 6 karakter</div>
                                @enderror

                                <!-- Show Password di bawah kanan -->
                                <div class="form-check mt-2 d-flex justify-content-end">
                                    <input class="form-check-input" type="checkbox" id="togglePasswordCheck">
                                    <label class="form-check-label ms-2 text-primary fw-semibold"
                                        for="togglePasswordCheck">
                                        Show Password
                                    </label>
                                </div>
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
        // Bootstrap Validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();

        // Toggle show/hide password
        const togglePasswordCheck = document.querySelector("#togglePasswordCheck");
        const passwordInput = document.querySelector("#password");

        togglePasswordCheck.addEventListener("change", function() {
            passwordInput.setAttribute("type", this.checked ? "text" : "password");
        });

        // Email domain validation with warning
        const emailInput = document.querySelector("#email");
        const emailFeedback = emailInput.nextElementSibling;
        const allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'student.polije.ac.id'];
        
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const domain = email.split('@')[1];
            
            if (email && domain && !allowedDomains.includes(domain)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                emailFeedback.textContent = 'Email harus menggunakan @gmail.com / @yahoo.com / @outlook.com / @student.polije.ac.id';
                emailFeedback.style.display = 'block';
            } else if (email && domain && allowedDomains.includes(domain)) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                emailFeedback.style.display = 'none';
            } else {
                this.classList.remove('is-invalid', 'is-valid');
                emailFeedback.style.display = 'none';
            }
        });

        // Prevent modal close on login errors
        const loginModal = document.querySelector('#loginModal');
        const loginForm = document.querySelector('form[action="{{ route('login') }}"]');
        let hasLoginError = false;

        // Check if there are validation errors on page load
        if (emailInput.classList.contains('is-invalid') || passwordInput.classList.contains('is-invalid')) {
            hasLoginError = true;
        }

        // Show modal if there are errors
        if (hasLoginError) {
            const modal = new bootstrap.Modal(loginModal);
            modal.show();
        }

        // Prevent modal close when there are errors
        loginModal.addEventListener('hide.bs.modal', function(event) {
            if (hasLoginError) {
                event.preventDefault();
                return false;
            }
        });

        // Reset error state on successful form submission
        loginForm.addEventListener('submit', function() {
            hasLoginError = false;
        });

        // Reset error state when modal is manually closed
        loginModal.addEventListener('hidden.bs.modal', function() {
            hasLoginError = false;
            // Clear form and validation states
            loginForm.reset();
            loginForm.classList.remove('was-validated');
            emailInput.classList.remove('is-invalid', 'is-valid');
            passwordInput.classList.remove('is-invalid', 'is-valid');
            emailFeedback.style.display = 'none';
        });
    </script>
</body>

</html>
