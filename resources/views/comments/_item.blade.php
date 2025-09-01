{{-- resources/views/comments/_item.blade.php --}}
<div class="card">
  <strong>{{ $comment->author_name }}</strong>
  <div>{{ $comment->body }}</div>
  <small>{{ $comment->created_at->diffForHumans() }}</small>
</div>