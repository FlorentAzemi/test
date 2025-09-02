<span class="badge" data-user-id="{{ $tag->id }}">
    {{ $tag->name }}
    <button class="btn" data-action="detach-tag" data-id="{{ $tag->id }}">×</button>
</span>
