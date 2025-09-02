@foreach($comments as $comment)
  <div class="card p-2 mb-1">
    <strong>{{ $comment->author_name }}</strong>: {{ $comment->body }}
    <br>
    <small>{{ $comment->created_at->diffForHumans() }}</small>
  </div>
@endforeach
