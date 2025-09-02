@extends('layouts.app')
@section('content')
<div class="grid">
  <div class="card">
    <form action="{{ route('tags.index') }}" method="POST">
      @csrf
      <h2>Create Tag</h2>
      <input name="name" placeholder="Name" required />
      <input name="color" placeholder="#hex or color" />
      <button style="display:inline-block; background-color: #000000; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;" class="btn btn-primary">Save</button>
    </form>
  </div>
  @foreach($tags as $t)
  <div class="card">
    <span class="badge" style="background: {{ $t->color ?? '#eee' }}">#{{ $t->name }}</span>
  </div>
  @endforeach
</div>
<div style="margin-top:1rem">{{ $tags->links() }}</div>
@endsection
