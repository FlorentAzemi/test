{{-- resources/views/issues/create.blade.php --}}
@extends('layouts.app')
@section('content')
<form action="{{ route('issues.store') }}" method="POST" class="card">
  @csrf
  <label>Project
    <select name="project_id" required>
      @foreach($projects as $p)
        <option value="{{ $p->id }}">{{ $p->name }}</option>
      @endforeach
    </select>
  </label>
  <input type="text" name="title" placeholder="Title" required />
  <textarea name="description" placeholder="Description"></textarea>
  <label>Status
    <select name="status">
      @foreach(['open','in_progress','closed'] as $s)
      <option value="{{ $s }}">{{ $s }}</option>
      @endforeach
    </select>
  </label>
  <label>Priority
    <select name="priority">
      @foreach(['low','medium','high'] as $p)
      <option value="{{ $p }}">{{ $p }}</option>
      @endforeach
    </select>
  </label>
  <label>Due Date <input type="date" name="due_date" /></label>
  <button class="btn btn-primary">Create</button>
</form>
@endsection
