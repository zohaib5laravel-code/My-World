 <div class="sidebar-widget">
     <h4 class="widget-title">Categories</h4>
     <div class="list-group list-group-flush">
         <a href="{{ route('frontend.posts') }}"
             class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('category') ? 'active' : '' }}">
             All Categories
             <span class="badge bg-primary rounded-pill">{{ \App\Models\Post::where('status', 'published')->count() }}</span>
         </a>
         @foreach($categories as $category)
         <a href="{{ route('frontend.posts', ['category' => $category->id]) }}"
             class="list-group-item list-group-item-action d-flex  align-items-center {{ request('category') == $category->id ? 'active' : '' }}">
             @if($category->image)
             <img src="{{ asset('assets/categories/' . $category->image) }}"
                 class="img-fluid me-2"
                 alt="{{ $category->name }}"
                 style="height: 60px; width: 60px; border-radius:50%; object-fit: cover;">

             @endif
             {{ $category->name }}
             <span class="ms-auto badge bg-primary rounded-pill">{{ $category->posts()->where('status', 'published')->count() }}</span>
         </a>
         @endforeach
     </div>
 </div>