<div class="comment" id="comment-{{ $comment->id }}">
    <div class="row">
        <div class="col-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&color=7C3AED&background=FBBF24"
                alt="{{ $comment->name }}"
                class="comment-avatar">
        </div>
        <div class="col">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex">
                    <h6 class="mb-1 me-3">{{ $comment->name }}</h6>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i>
                        {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>


            </div>
            <p class="mb-0">{{ $comment->comment }}</p>

        </div>
    </div>


</div>