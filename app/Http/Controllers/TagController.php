<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::orderBy('name')->paginate(20);
        return view('tags.index', compact('tags'));
    }
    public function store(StoreTagRequest $request) {
        Tag::create($request->validated());
        return back()->with('success','Tag created');
    }
}

