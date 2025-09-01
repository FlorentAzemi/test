{{-- resources/views/comments/_list.blade.php --}}
@foreach($comments as $comment)
  @include('comments._item', ['comment'=>$comment])
@endforeach