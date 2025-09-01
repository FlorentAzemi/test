{{-- resources/views/projects/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Edit Project</h2>

    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $project->name) }}">
            @error('name')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <button  
        style="display:inline-block; background-color:#1E90FF; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;"
        type="submit"
            >Update</button>
        <a style="display:inline-block; background-color:#f44336; color:white; padding:.5rem 1rem; border-radius:.25rem; text-decoration:none;" href="{{ route('projects.show', $project) }}">
            Cancel</a>
    </form>
</div>
@endsection
