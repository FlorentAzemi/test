@extends('layouts.app') 
@section('content') 

<form method="GET" action="" class="card" style="display:grid; grid-template-columns: repeat(5, 1fr); gap: .5rem; align-items:end; padding=10px;">
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
            <button style="display:inline-block; background-color: #000000; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;" class="btn btn-primary ml-4">Search</button> 
        </div> 
    </div> 
</form> 

<div class="grid" style="display:grid; grid-template-columns: repeat(2, 1fr); gap:1rem; padding:1rem;">
    @foreach($issues as $i) 
    <div class="card" style="padding:1rem; border:1px solid #ddd; border-radius:.5rem;"> 
        <h3><a href="{{ route('issues.show',$i) }}"><strong>{{ $i->title }}</strong></a></h3> 
        <p>Project: <a href="{{ route('projects.show',$i->project) }}">{{ $i->project->name }}</a></p> 
        <p>Status: <span class="badge">{{ $i->status }}</span> | Priority: <span class="badge">{{ $i->priority }}</span> | Due: {{ $i->due_date?->toDateString() ?? '—' }}</p> 
        <p> 
            @foreach($i->tags as $t) 
                <span class="badge" style="background:{{ $t->color ?? '#eee' }}">#{{ $t->name }}</span> 
            @endforeach 
        </p> 
        <div style="margin-top:.5rem; display:flex; gap:.5rem;"> 
            <a href="{{ route('issues.edit', $i) }}" style="background-color:#1E90FF; color:white; padding:.25rem .75rem; border-radius:.25rem; text-decoration:none;"> Edit </a> 
            <form action="{{ route('issues.destroy', $i) }}" method="POST" onsubmit="return confirm('Delete issue?')"> 
                @csrf 
                @method('DELETE') 
                <button type="submit" style="background-color:#f44336; color:white; padding:.25rem .75rem; border:none; border-radius:.25rem;"> Delete </button> 
            </form> 
        </div> 
    </div> 
    @endforeach 
</div> 

<div style="margin-top:1rem">{{ $issues->links() }}</div> 

<script> 
    const q = document.getElementById('q'); 
    let timer; 
    q?.addEventListener('input', ()=>{ 
        clearTimeout(timer); 
        timer = setTimeout(()=>{ 
            q.form.submit(); 
        }, 400); 
    }); 
</script> 

@endsection
