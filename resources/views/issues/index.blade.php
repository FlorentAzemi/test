{{-- resources/views/issues/index.blade.php --}}
@extends('layouts.app')
@section('content')
<form method="GET" action="" class="card" style="display:grid; grid-template-columns: repeat(5, 1fr); gap: .5rem; align-items:end;">
  <div>
    <label>Status</label>
    <select name="status">
      <option value="">Any</option>
      @foreach(['open','in_progress','closed'] as $s)
        <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label>Priority</label>
    <select name="priority">
      <option value="">Any</option>
      @foreach(['low','medium','high'] as $p)
        <option value="{{ $p }}" @selected(request('priority')===$p)>{{ $p }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label>Tag</label>
    <select name="tag_id">
      <option value="">Any</option>
      @foreach($tags as $t)
        <option value="{{ $t->id }}" @selected(request('tag_id')==$t->id)>{{ $t->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="flex">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Title or description" id="q" />
      <div>
    <button  style="display:inline-block; background-color: #000000; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;" class="btn btn-primary ml-4">Search</button>
  </div>
  </div>

</form>

<div class="grid" style="margin-top:1rem">
  @foreach($issues as $i)
  <div class="card">
    <h3><a href="{{ route('issues.show',$i) }}">{{ $i->title }}</a></h3>
    <p>Project: <a href="{{ route('projects.show',$i->project) }}">{{ $i->project->name }}</a></p>
    <p>Status: <span class="badge">{{ $i->status }}</span> | Priority: <span class="badge">{{ $i->priority }}</span> | Due: {{ $i->due_date?->toDateString() ?? '—' }}</p>
    <p>@foreach($i->tags as $t) <span class="badge" style="background:{{ $t->color ?? '#eee' }}">#{{ $t->name }}</span> @endforeach</p>
  </div>
  @endforeach
</div>
<div style="margin-top:1rem">{{ $issues->links() }}</div>

@push('scripts')
<script>
const q = document.getElementById('q');
let timer; q?.addEventListener('input', ()=>{ clearTimeout(timer); timer = setTimeout(()=>{ q.form.submit(); }, 400); });
</script>
@endpush
@endsection
