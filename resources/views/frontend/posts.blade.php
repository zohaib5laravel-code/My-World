@extends('frontend.app')
@section('content')


<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-3">My Stories & Thoughts</h1>
                <p class="lead mb-4">Explore my journey through personal stories, reflections, and experiences shared from my world.</p>

                <!-- Search Bar -->
                <form action="{{ route('frontend.posts') }}" method="GET" class="row g-2 justify-content-center">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text"
                                class="form-control form-control-lg"
                                name="search"
                                placeholder="Search posts..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content py-4">
    <div class="container">
        <div class="row">
            <!-- Posts Column -->
            <div class="col-lg-8">
                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="row align-items-center ">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="me-3 text-muted">Filter:</span>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('frontend.posts', array_merge(request()->except('category'), ['category' => ''])) }}"
                                        class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">
                                        All
                                    </a>
                                    @foreach($categories as $category)
                                    <a href="{{ route('frontend.posts', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                                        class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <span class="me-3 text-muted">Sort by:</span>
                                <select class="form-select form-select-sm w-auto" onchange="window.location.href=this.value">
                                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                        {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                                        Newest First
                                    </option>
                                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'oldest'])) }}"
                                        {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                        Oldest First
                                    </option>
                                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                                        {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                        Most Popular
                                    </option>
                                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'commented'])) }}"
                                        {{ request('sort') == 'commented' ? 'selected' : '' }}>
                                        Most Commented
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posts Grid -->
                @if($posts->count() > 0)
                <div class="row justify-content-center">
                    @foreach($posts as $post)
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="post-card">
                            <!-- Post featured image -->
                            @if($post->featured_image)
                            <div class="post-card-img-container" style="height: 220px; overflow: hidden;">
                                <img src="{{ asset('assets/posts/' . $post->featured_image) }}"
                                    alt="{{ $post->title }}"
                                    class="post-card-img">
                            </div>
                            @else
                            <div class="post-card-img-container" style="height: 220px; overflow: hidden; background: linear-gradient(135deg, #4a6fa5, #166088);">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-newspaper text-white" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            @endif

                            <!-- Post Content -->
                            <div class="post-card-body">
                                @if($post->category)
                                <span class="post-category">{{ $post->category->name }}</span>
                                @endif

                                <h3 class="post-title">
                                    <a href="{{ route('frontend.post', $post) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h3>

                                <p class="post-excerpt">
                                    {{ Str::limit($post->excerpt, 120) }}
                                </p>

                                <div class="post-meta">
                                    <!-- <i class="far fa-user"></i> {{ $post->user->name ?? 'Admin' }} -->
                                    <i class="far fa-calendar ms-3"></i> {{ $post->created_at->format('M d, Y') }}
                                    <i class="far fa-eye ms-3"></i> {{ $post->views }}
                                    <i class="far fa-comment ms-3"></i> {{ $post->approvedComments()->count() }}
                                </div>

                                <a href="{{ route('frontend.post', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($posts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($posts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <h3 class="mb-3">No Posts Found</h3>
                    <p class="text-muted mb-4">
                        @if(request()->has('search') || request()->has('category'))
                        Try adjusting your search or filter to find what you're looking for.
                        @else
                        No posts have been published yet. Check back soon!
                        @endif
                    </p>
                    @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('frontend.posts') }}" class="btn btn-primary">
                        <i class="fas fa-times me-2"></i>Clear Filters
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- About Widget -->
                <div class="sidebar-widget">
                    <h4 class="widget-title">About This Blog</h4>
                    <p>Welcome to my personal blog where I share stories from my journey, thoughts on life, and experiences worth remembering.</p>
                    <p>Every post is a piece of my world - from travels and adventures to quiet moments of reflection.</p>
                </div>

                <!-- Categories -->
                @include('frontend.components.categories')
               

                <!-- Popular Posts Widget -->
                <div class="sidebar-widget">
                    <h4 class="widget-title">Popular Posts</h4>
                    @foreach($popularPosts as $popularPost)
                    <div class="popular-post">
                        @if($popularPost->featured_image)
                        <img src="{{ asset('assets/posts/' . $popularPost->featured_image) }}"
                            alt="{{ $popularPost->title }}"
                            class="popular-post-img">
                        @else
                        <div class="popular-post-img d-flex align-items-center justify-content-center"
                            style="background: linear-gradient(135deg, #4a6fa5, #166088);">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('frontend.post', $popularPost) }}"
                                    class="text-decoration-none text-dark">
                                    {{ Str::limit($popularPost->title, 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-eye"></i> {{ $popularPost->views }} views
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Newsletter Widget -->
                @include('frontend.components.newsletter')
            </div>
        </div>
    </div>
</section>


@endsection