@extends('layouts.app')
@section('content')
<div class="card " style="padding: 14px;">
  <h2>Project Name: {{ $project->name }}</h2>
  <p> Description:  {{ $project->description }}</p>
  <p> Start Date :  {{ $project->start_date }}</p>
   <p> Deadline:  {{ $project->deadline }}</p>
</div>
<div class="grid" style="margin-top:1rem">
  @foreach($issues as $issue)
  <div class="card">
    <h3><a href="{{ route('issues.show',$issue) }}">{{ $issue->title }}</a></h3>
    <p>Status: <span class="badge">{{ $issue->status }}</span> | Priority: <span class="badge">{{ $issue->priority }}</span></p>
    <p>
      @foreach($issue->tags as $t)
        <span class="badge" title="{{ $t->name }}" style="background: {{ $t->color ?? '#eee' }}">#{{ $t->name }}</span>
      @endforeach
    </p>
  </div>
  @endforeach
</div>
<div style="margin-top:1rem">{{ $issues->links() }}</div>
<a  style="display:inline-block; background-color: #000000; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;"href="{{ route('issues.create') }}?project_id={{ $project->id }}">Add Issue</a>

@endsection
