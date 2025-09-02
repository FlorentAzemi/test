@extends('layouts.app')
@section('content')
<div class="card">
    <h2>Issue: <strong>{{ $issue->title }}</strong></h2>
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

    {{-- Comments --}}
   <h3 style="margin-top:1rem;">Comments</h3>
<div id="comments-list"></div>

<div id="comment-form" class="card p-2" style="display:flex; flex-direction:column; gap:.5rem; width:300px;">
    <input type="text" id="author_name" placeholder="Your name" class="input">
    <textarea id="body" placeholder="Write a comment…" class="input" rows="3"></textarea>
    <button class="btn" type="button" id="submit-comment">Add Comment</button>
</div>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    console.log('Comment script loaded');

    const submitBtn = document.getElementById('submit-comment');
    const authorInput = document.getElementById('author_name');
    const bodyInput = document.getElementById('body');
    const commentsList = document.getElementById('comments-list');

    async function loadComments() {
        try {
            const res = await fetch("{{ route('issues.comments.index', $issue) }}", {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            commentsList.innerHTML = data.html;
        } catch (e) {
            console.error(e);
        }
    }

    loadComments();

    submitBtn.addEventListener('click', async () => {
        const author_name = authorInput.value.trim();
        const body = bodyInput.value.trim();

        if (!body) return alert("Comment body is required");

        try {
            const res = await fetch("{{ route('issues.comments.store', $issue) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ author_name, body })
            });

            const json = await res.json();

            if (json.ok) {
                commentsList.insertAdjacentHTML('afterbegin', json.html);
                authorInput.value = '';
                bodyInput.value = '';
            } else {
                alert("Failed to add comment");
            }
        } catch (e) {
            console.error(e);
            alert("An error occurred");
        }
    });

});

document.addEventListener('DOMContentLoaded', () => {

    // ---------------- TAGS ----------------
    const tagBtn = document.getElementById('attach-tag-btn');
    const tagSelect = document.getElementById('attach-tag');
    const tagList = document.getElementById('tag-list');

    // Attach tag
    tagBtn.addEventListener('click', async () => {
        const tag_id = tagSelect.value;
        if (!tag_id) return alert("Select a tag first");

        try {
            const res = await fetch("{{ route('issues.tags.attach', $issue) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tag_id })
            });

            const json = await res.json();
            if (json.ok) {
                tagList.insertAdjacentHTML('beforeend', json.html);
            } else {
                alert("Failed to attach tag");
            }
        } catch (e) { console.error(e); }
    });

    // Detach tag
    tagList.addEventListener('click', async (e) => {
        if (e.target.dataset.action === 'detach-tag') {
            const tagId = e.target.dataset.id;
            try {
                const res = await fetch(`/issues/{{ $issue->id }}/tags/${tagId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                if (json.ok) {
                    e.target.parentElement.remove();
                }
            } catch (e) { console.error(e); }
        }
    });


    // ---------------- MEMBERS ----------------
    const attachBtn = document.getElementById('attach-member-btn');
    const attachSelect = document.getElementById('attach-member');
    const memberList = document.getElementById('member-list');

    // Attach member
    attachBtn.addEventListener('click', async () => {
        const user_id = attachSelect.value;
        if (!user_id) return alert("Select a user first");

        try {
            const res = await fetch("{{ route('issues.members.attach', $issue) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id })
            });
            const json = await res.json();
            if (json.ok) {
                memberList.insertAdjacentHTML('beforeend', json.html);
            }
        } catch (e) { console.error(e); }
    });

    // Detach member
    memberList.addEventListener('click', async (e) => {
        if (e.target.dataset.action === 'detach-user') {
            const userId = e.target.dataset.id;
            try {
                const res = await fetch(`/issues/{{ $issue->id }}/members/${userId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await res.json();
                if (json.ok) {
                    e.target.parentElement.remove();
                }
            } catch (e) { console.error(e); }
        }
    });

});


</script>


@endsection
