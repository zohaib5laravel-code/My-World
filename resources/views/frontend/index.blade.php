@extends('frontend.app')
@section('content')

<section class="banner-carousel">
    <!-- Carousel -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true" data-bs-interval="5000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            @if(isset($pictures) && $pictures->where('type','banner')->count() > 0)
            @php $banners = $pictures->where('type','banner') @endphp
            @foreach($banners as $banner)
            <button
                type="button"
                data-bs-target="#bannerCarousel"
                data-bs-slide-to="{{ $loop->index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-label="Slide {{ $loop->iteration }}">
            </button>

            @endforeach
            @else
            <button type="button"
                data-bs-target="#bannerCarousel"
                data-bs-slide-to="0"
                class="active"
                aria-label="Slide 1">
            </button>
            <button type="button"
                data-bs-target="#bannerCarousel"
                data-bs-slide-to="1"
                aria-label="Slide 2">
            </button>
            <button type="button"
                data-bs-target="#bannerCarousel"
                data-bs-slide-to="2"
                aria-label="Slide 3">
            </button>
            @endif
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            @if(isset($pictures) && $pictures->where('type','banner')->count() > 0)
            @php $banners = $pictures->where('type','banner') @endphp
            @foreach($banners as $banner)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img loading="lazy" src="{{ asset('assets/pictures/' . $banner->image) }}"
                    class="d-block w-100"
                    alt="{{ $banner->title ?? 'Banner Image' }}"
                    style="height: 500px; object-fit: cover;">
                @if($banner->title)
                <div class="carousel-caption d-none d-md-block">
                    <p>{!! $banner->title !!}</p>
                </div>
                @endif
            </div>
            @endforeach
            @else
            <!-- Default banners if none in database -->
            <div class="carousel-item active">
                <img loading="lazy" src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100"
                    alt="My World Banner 1"
                    style="height: 500px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Welcome to My World</h3>
                    <p>A personal space to share my journey, thoughts, and memories</p>
                </div>
            </div>
            <div class="carousel-item">
                <img loading="lazy" src="https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100"
                    alt="My World Banner 2"
                    style="height: 500px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Explore My Gallery</h3>
                    <p>Discover the moments I've captured and want to share with you</p>
                </div>
            </div>
            <div class="carousel-item">
                <img loading="lazy" src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                    class="d-block w-100"
                    alt="My World Banner 3"
                    style="height: 500px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Read My Stories</h3>
                    <p>Personal posts about experiences, thoughts, and discoveries</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


</section>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 mb-4">Welcome to <span class="text-warning">My World</span></h1>
                <p class="lead mb-4">This is my personal space where I share my journey through photos, stories, and experiences. Every image tells a story, and every post captures a moment in time.</p>
                <a href="#gallery" class="btn btn-primary btn-lg me-3"><i class="fas fa-images me-2"></i>Explore Gallery</a>
                <a href="#posts" class="btn btn-outline-light btn-lg"><i class="fas fa-newspaper me-2"></i>Read Posts</a>
            </div>
            <div class="col-lg-4 text-center">
                <div class="rounded-circle bg-white p-4 d-inline-block">
                    <i class="fas fa-globe-americas text-primary" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="posts" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Recent Posts</h2>

        <div class="row">
            <!-- Dynamic content from Laravel backend -->
            @if(isset($posts) && count($posts) > 0)
            @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card featured-post shadow-sm h-100">
                    @if($post->featured_image)
                    <img loading="lazy" src="{{ asset('assets/posts/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img loading="lazy" src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Post Image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="post-meta mb-2">
                            <i class="far fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                            <i class="fas fa-tag ms-3"></i> {{ $post->category->name }}
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{!! Str::limit($post->content, 150) !!}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('frontend.post', $post->slug) }}" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <!-- Default posts if none in database -->
            <div class="col-md-4 mb-4">
                <div class="card featured-post shadow-sm h-100">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <div class="post-meta mb-2">
                            <i class="far fa-calendar"></i> June 15, 2023
                            <i class="fas fa-tag ms-3"></i> Travel
                        </div>
                        <h5 class="card-title">My Journey to the Mountains</h5>
                        <p class="card-text">Discovering the beauty of nature and finding peace in the high altitudes. An unforgettable experience that changed my perspective.</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card featured-post shadow-sm h-100">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <div class="post-meta mb-2">
                            <i class="far fa-calendar"></i> May 22, 2023
                            <i class="fas fa-tag ms-3"></i> Food
                        </div>
                        <h5 class="card-title">Culinary Adventures in Italy</h5>
                        <p class="card-text">Exploring the rich flavors of Italian cuisine, from homemade pasta to the perfect espresso. A food lover's dream come true.</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card featured-post shadow-sm h-100">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <div class="post-meta mb-2">
                            <i class="far fa-calendar"></i> April 10, 2023
                            <i class="fas fa-tag ms-3"></i> Reflection
                        </div>
                        <h5 class="card-title">Finding Balance in a Busy World</h5>
                        <p class="card-text">Thoughts on maintaining mental well-being and finding moments of peace in our increasingly fast-paced lives.</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('frontend.posts') }}" class="btn btn-primary btn-lg">View All Posts</a>
        </div>
    </div>
</section>

<section id="gallery" class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Photo Gallery</h2>
        <p class="text-center mb-5">A collection of my favorite moments captured through the lens</p>

        <div class="row">
            <!-- Dynamic content from Laravel backend -->
            @if(isset($pictures) && $pictures->where('type','gallery')->count() > 0)
            @foreach($pictures->where('type','gallery')->take(6) as $image)
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="{{ asset('assets/pictures/' . $image->image) }}" alt="{{ $image->title }}">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white opacity-0 hover-opacity-100 transition-all">
                        <p class="text-center">{!! $image->title !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <!-- Default gallery images if none in database -->
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mountain Landscape">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1439066615861-d1af74d74000?ixlib=rb-4.0.3&auto=format&fit=crop&w-800&q=80" alt="Forest Path">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1475924156734-496f6cac6ec1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ocean Waves">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="City Lights">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Snowy Peaks">
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Northern Lights">
                </div>
            </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('frontend.gallery') }}" class="btn btn-primary btn-lg">View Full Gallery</a>
        </div>
    </div>
</section>

<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">About My World</h2>
                <p>Welcome to my personal corner of the internet. This space is a reflection of my journey, interests, and the moments that matter to me.</p>
                <p>Through photos and posts, I share glimpses of my experiences, thoughts, and discoveries. Each image in the gallery represents a memory, and every post is a story from my life.</p>
                <p>This website is built with Laravel and Bootstrap, allowing me to easily manage and share content through the admin panel. I hope you enjoy exploring My World as much as I enjoy sharing it.</p>
                <div class="mt-4">
                    <h5>Follow My Journey</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rounded shadow overflow-hidden">
                    <img loading="lazy" src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="About My World" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#') {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    const myCarousel = document.querySelector('#bannerCarousel');
    const carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
        wrap: true,
        keyboard: true
    });


</script>
@endsection