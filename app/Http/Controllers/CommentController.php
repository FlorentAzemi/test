<?php

namespace App\Http\Controllers;
use App\Models\Issue;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Issue $issue) {
        $comments = $issue->comments()->paginate(5);
        $html = view('comments._list', compact('comments'))->render();
        return response()->json([
            'html' => $html,
            'next' => $comments->nextPageUrl(),
        ]);
    }
    public function store(StoreCommentRequest $request, Issue $issue) {
        $comment = $issue->comments()->create($request->validated());
        $html = view('comments._item', compact('comment'))->render();
        return response()->json(['ok'=>true,'html'=>$html]);
    }
}