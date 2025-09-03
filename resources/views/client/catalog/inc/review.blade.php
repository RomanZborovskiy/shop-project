<div class="border p-3 mb-3 rounded">
    <div class="d-flex justify-content-between">
        <strong>{{ $review->user->name ?? 'Анонім' }}</strong>
        <span class="text-warning">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa fa-star{{ $i <= $review->rating ? ' text-secondary' : '' }}"></i>
            @endfor
        </span>
    </div>

    <p class="mb-1">{{ $review->comment }}</p>
    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>

    <button class="btn btn-sm btn-link text-primary" 
            onclick="document.getElementById('reply-form-{{ $review->id }}').classList.toggle('d-none')">
        Відповісти
    </button>

    <form id="reply-form-{{ $review->id }}" 
          class="d-none mt-2" 
          action="{{ route('client.reviews.store', $review->product) }}" 
          method="POST">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $review->id }}">
        <div class="mb-2">
            <textarea name="comment" class="form-control" rows="2" placeholder="Ваша відповідь..."></textarea>
        </br>
            <select name="rating" required class="form-control">
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Надіслати</button>
    </form>

    @if($review->replies->count())
        <div class="ms-4 mt-3">
            @foreach($review->replies as $reply)
                @include('client.catalog.inc.review', ['review' => $reply])
            @endforeach
        </div>
    @endif
</div>
