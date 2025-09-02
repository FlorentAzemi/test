@extends('layouts.app')

@section('content')

<form action="{{ route('issues.update', $issue) }}" method="POST" style="display:flex; flex-direction:column; gap:.5rem; width: 400px">
    @csrf
    @method('PUT')

    <p><strong>Project:</strong> {{ $issue->project->name }}</p>

    <input type="text" name="title" placeholder="Title" value="{{ $issue->title }}" required />
    <textarea name="description" placeholder="Description">{{ $issue->description }}</textarea>

    <label>Status
        <select name="status">
            @foreach(['open','in_progress','closed'] as $s)
                <option value="{{ $s }}" @selected($issue->status==$s)>{{ $s }}</option>
            @endforeach
        </select>
    </label>

    <label>Priority
        <select name="priority">
            @foreach(['low','medium','high'] as $p)
                <option value="{{ $p }}" @selected($issue->priority==$p)>{{ $p }}</option>
            @endforeach
        </select>
    </label>

    <label>Due Date
        <input type="date" name="due_date" value="{{ $issue->due_date?->toDateString() }}" />
    </label>

    <button class="btn btn-primary" type="submit">Update Issue</button>
</form>

<script>

</script>



@endsection 