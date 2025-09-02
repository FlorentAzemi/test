@extends('layouts.app')
@section('content')
<div class="grid" style="gap:1rem;">
  {{-- Create Project --}}
  <div class="card" style="padding-left:1rem; padding-top:1rem; padding-bottom:1rem;">
    <form action="{{ route('projects.store') }}" method="POST" style="display:flex; flex-direction:column; gap:.5rem;">
      @csrf
      <h2>Create Project</h2>
      <input name="name" placeholder="Name" required 
             style="width:400px; max-width:100%; padding:.5rem; border:1px solid #ccc; border-radius:.25rem;" />

      <textarea name="description" placeholder="Description" 
                style="width:400px; max-width:100%; padding:.5rem; border:1px solid #ccc; border-radius:.25rem;"></textarea>
      <label>Start date <input type="date" name="start_date" /></label>
      <label>Deadline <input type="date" name="deadline" /></label>
      <div>
        <button style="background-color:#4CAF50; color:white; padding:.5rem 1rem; border:none; border-radius:.25rem;">
          Save
        </button>
      </div>
    </form>
  </div>

  {{-- Projects List --}}
  <div class="grid" style="display:grid; grid-template-columns: repeat(2, 1fr); gap:1rem; padding:1rem;">
    @foreach($projects as $p)
      <div class="card" style="display:flex; flex-direction:column; border:1px solid #ddd; border-radius:.5rem; gap:.25rem; padding-left:1rem; padding-top:.5rem; padding-bottom:.5rem;">
        <h3><a href="{{ route('projects.show',$p) }}">Project: <Strong>{{ $p->name }}</Strong></a></h3>
        <p style="margin:0;">Description: {{ Str::limit($p->description,120) }}</p>
        <p style="margin:0;">Issues: <strong>{{ $p->issues_count }}</strong></p>
        <p style="margin:0;">Start Date  <strong>{{ \Illuminate\Support\Str::substr($p->start_date,0,10) ?? '—' }}</strong></p>
        <p style="margin:0;">Deadline: <strong>{{ \Illuminate\Support\Str::substr($p->deadline,0,10) ?? '—' }}</strong></p>
        <form class="inline" action="{{ route('projects.destroy',$p) }}" method="POST" style="margin-top:.5rem;">
          @csrf @method('DELETE')
          <a href="{{ route('projects.edit',$p) }}" 
             style="display:inline-block; background-color:#1E90FF; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;">
             Edit
          </a>
          <button style="background-color:#f44336; color:white; padding:.5rem 1rem; border:none; border-radius:.25rem;" onclick="return confirm('Delete project?')">Delete</button>
        </form>
      </div>
    @endforeach
  </div>
</div>

<div style="margin-top:2rem">{{ $projects->links() }}</div>
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
