<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My World - Welcome to My Space</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --accent-color: #ff7e5f;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --text-color: #333;
            --text-light: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .display-font {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .navbar {
            background: transparent !important;
            transition: all 0.3s ease;
            padding: 20px 0;
            z-index: 1030;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .navbar-scrolled .navbar-brand {
            color: #4a6fa5 !important;
        }

        .navbar-scrolled .nav-link {
            color: #333 !important;
        }

        .navbar-scrolled .nav-link:hover,
        .navbar-scrolled .nav-link.active {
            color: #4a6fa5 !important;
        }

        /* Navbar link styles for transparent state */
        .navbar .navbar-brand {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            transition: all 0.3s ease;
        }

        .navbar .navbar-brand:hover {
            color: rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
        }

        .navbar .nav-link {
            color: white;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 16px !important;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .navbar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.25);
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after {
            width: 70%;
        }

        /* Navbar toggler for transparent state */
        .navbar .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            margin-bottom: 50px;
        }

        .section-title {
            position: relative;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
        }

        .section-title.text-center::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .featured-post {
            transition: transform 0.3s ease;
            height: 100%;
        }

        .featured-post:hover {
            transform: translateY(-5px);
        }

        .gallery-item {
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 20px;
            height: 250px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .post-meta {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .post-meta i {
            margin-right: 5px;
        }

        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 60px 0 30px;
            margin-top: 80px;
        }

        .social-icons a {
            color: var(--light-color);
            font-size: 1.2rem;
            margin-right: 15px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--accent-color);
        }

        .banner-carousel .carousel-item {
            height: 500px;
        }

        .banner-carousel .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 8px;
            bottom: 20%;
        }

        @media (max-width: 768px) {
            .navbar-collapse {
                background: rgba(0, 0, 0, 0.85);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 10px;
                padding: 20px;
                margin-top: 15px;
            }

            .navbar-scrolled .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
            }

            .navbar-scrolled .navbar-collapse .nav-link {
                color: #333 !important;
            }

            .hero-section {
                padding: 80px 0;
            }

            .banner-carousel .carousel-item {
                height: 350px;
            }

            .carousel-caption {
                bottom: 10%;
                padding: 15px;
            }

            .carousel-caption h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    @include('frontend.components.header')
    @yield('content')
    @include('frontend.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    navbar.classList.add('navbar-scrolled');
                    navbar.classList.remove('navbar-dark');
                    navbar.classList.add('navbar-light');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                    navbar.classList.remove('navbar-light');
                    navbar.classList.add('navbar-dark');
                }
            });

            // Smooth scrolling for navbar links
            document.querySelectorAll('.navbar .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);

                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 70,
                                behavior: 'smooth'
                            });

                            // Close mobile menu if open
                            const navbarCollapse = document.querySelector('.navbar-collapse');
                            if (navbarCollapse.classList.contains('show')) {
                                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                                bsCollapse.hide();
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>