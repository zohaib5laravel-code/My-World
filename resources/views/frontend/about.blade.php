@extends('frontend.app')
@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="hero-content text-center">
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                    alt="{{ $personalInfo['name'] }}">
            </div>
            <h1 class="display-4 mb-3">Hello, I'm <span class="text-warning">{{ $personalInfo['name'] }}</span></h1>
            <p class="lead mb-4">Welcome to my personal corner of the internet</p>
            <a href="#story" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-down me-2"></i>My Story
            </a>
        </div>
    </div>
</section>

<!-- Personal Introduction -->
<section id="story" class="section-padding">
    <div class="container">
        <div class="personal-intro">
            <h2 class="section-title mb-4">The Person Behind the Lens</h2>
            <p class="lead mb-4">{{ $personalInfo['bio'] }}</p>

            <div class="intro-quote">
                {{ $personalInfo['quote'] }}
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">My Mission</h4>
                    <p>{{ $personalInfo['mission'] }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Currently In</h4>
                    <p class="h5 text-primary">{{ $personalInfo['location'] }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="mb-3">Things I Love</h4>
                <div class="interests">
                    @foreach($personalInfo['interests'] as $interest)
                    <span class="interest-tag">{{ $interest }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section-padding stats-section">
    <div class="container">
        <h2 class="section-title text-center text-white mb-5">My World in Numbers</h2>
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card fade-in">
                    <div class="stat-number">{{ $stats['totalPosts'] }}+</div>
                    <div class="stat-label">Stories Shared</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card fade-in">
                    <div class="stat-number">{{ $stats['totalPhotos'] }}+</div>
                    <div class="stat-label">Moments Captured</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card fade-in">
                    <div class="stat-number">{{ $stats['countriesFeatured'] }}+</div>
                    <div class="stat-label">Countries Featured</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card fade-in">
                    <div class="stat-number">{{ $stats['yearsWriting'] }}+</div>
                    <div class="stat-label">Years of Journey</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">What Guides My Journey</h2>
        <div class="row g-4">
            @foreach($values as $value)
            <div class="col-md-3 col-sm-6">
                <div class="value-card fade-in">
                    <div class="value-icon">
                        <i class="{{ $value['icon'] }}"></i>
                    </div>
                    <h4 class="mb-3">{{ $value['title'] }}</h4>
                    <p class="mb-0">{{ $value['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Journey Timeline -->
<section class="section-padding">
    <div class="container">
        <h2 class="section-title text-center mb-5">My Journey So Far</h2>
        <div class="timeline">
            @foreach($journey as $index => $milestone)
            <div class="timeline-item fade-in">
                <div class="timeline-year">{{ $milestone['year'] }}</div>
                <div class="timeline-content">
                    <h4 class="mb-3">{{ $milestone['title'] }}</h4>
                    <p class="mb-0">{{ $milestone['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Favorites Section -->
<section class="section-padding favorites-section">
    <div class="container">
        <h2 class="section-title text-center mb-5">My Favorites</h2>
        <div class="row g-4">
            @foreach($favorites as $favorite)
            <div class="col-md-3 col-sm-6">
                <div class="favorite-card fade-in">
                    <h4 class="mb-3">{{ $favorite['type'] }}</h4>
                    @foreach($favorite['items'] as $item)
                    <div class="favorite-item">
                        <i class="fas fa-check text-primary me-2"></i>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- Contact Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-card">
                    <h2 class="section-title text-center mb-4">Let's Connect</h2>
                    <p class="text-center mb-4">I love connecting with fellow travelers, photographers, and story lovers. Feel free to reach out!</p>

                    <div class="social-links">
                        <a href="#" class="social-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="Pinterest">
                            <i class="fab fa-pinterest"></i>
                        </a>
                        <a href="#" class="social-link" title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>

                    <div class="signature">
                        {{ $personalInfo['name'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection