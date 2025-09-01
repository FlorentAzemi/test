@extends('layouts.app')
@section('content')
<div class="card">
  <h2>Issue:  <strong>{{ $issue->title }}</Strong></h2>
  <p>Project: <a href="{{ route('projects.show',$issue->project) }}">{{ $issue->project->name }}</a></p>
  <p>Status: <span class="badge">{{ $issue->status }}</span> | Priority: <span class="badge">{{ $issue->priority }}</span> | Due: {{ $issue->due_date?->toDateString() ?? '—' }}</p>
  <p>{{ $issue->description }}</p>

  {{-- Tags --}}
  <h3>Tags</h3>
  <div id="tag-list">
    @foreach($issue->tags as $t)
      <span class="badge" data-tag-id="{{ $t->id }}" style="background:{{ $t->color ?? '#eee' }}">
        #{{ $t->name }}
        <button class="btn" data-action="detach-tag" data-id="{{ $t->id }}">×</button>
      </span>
    @endforeach
  </div>

  <div class="card" style="margin-top:1rem">
    <h4>Attach Tag</h4>
    <select id="attach-tag">
      <option value="">Choose tag…</option>
      @foreach(\App\Models\Tag::orderBy('name')->get() as $opt)
        <option value="{{ $opt->id }}">{{ $opt->name }}</option>
      @endforeach
    </select>
    <button class="btn" id="attach-tag-btn">Attach</button>
  </div>

  {{-- Members --}}
  <h3 style="margin-top:1rem;">Members</h3>
  <div id="member-list">
    @foreach($issue->members as $member)
      <span class="badge" data-user-id="{{ $member->id }}">
        {{ $member->name }}
        <button class="btn" data-action="detach-user" data-id="{{ $member->id }}">×</button>
      </span>
    @endforeach
  </div>

  <div style="margin-top:.5rem">
    <select id="attach-member">
      <option value="">Choose user…</option>
      @foreach(\App\Models\User::orderBy('name')->get() as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
      @endforeach
    </select>
    <button class="btn" id="attach-member-btn">Attach</button>
  </div>

</div>

@push('scripts')
<script>
async function post(url, data={}, method='POST'){
    const res = await fetch(url, {
        method,
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body: method!=='GET'?JSON.stringify(data):null
    });
    return res.json();
}

// Tags
document.getElementById('attach-tag-btn').addEventListener('click', async () => {
    const tagId = document.getElementById('attach-tag').value;
    if(!tagId) return;
    const res = await post(`{{ route('issues.tags.attach',['issue'=>$issue->id,'tag'=>'__TAG__']) }}`.replace('__TAG__', tagId));
    if(res.ok) location.reload();
});

document.getElementById('tag-list').addEventListener('click', async (e) => {
    if(e.target.dataset.action==='detach-tag'){
        const tagId = e.target.dataset.id;
        const res = await post(`{{ route('issues.tags.detach',['issue'=>$issue->id,'tag'=>'__TAG__']) }}`.replace('__TAG__', tagId), {}, 'DELETE');
        if(res.ok) e.target.closest('span').remove();
    }
});

// Members
document.getElementById('attach-member-btn').addEventListener('click', async () => {
    const userId = document.getElementById('attach-member').value;
    if(!userId) return;
    const res = await post(`{{ route('issues.users.attach', ['issue' => $issue->id]) }}`, { user_id: userId });
    if(res.ok) location.reload();
});

document.getElementById('member-list').addEventListener('click', async (e) => {
    if(e.target.dataset.action==='detach-user'){
        const userId = e.target.dataset.id;
        const res = await post(`{{ route('issues.users.detach', ['issue' => $issue->id, 'user' => '__USER__']) }}`.replace('__USER__', userId), {}, 'DELETE');
        if(res.ok) e.target.closest('span').remove();
    }
});
</script>
@endpush

@endsection
