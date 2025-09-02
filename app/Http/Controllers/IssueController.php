<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request) {
        $q = Issue::query()->with(['project','tags']);
        $issues = $q
            ->status($request->status)
            ->priority($request->priority)
            ->withTag($request->tag_id)
            ->search($request->q)
            ->latest()->paginate(12)->withQueryString();
        $tags = Tag::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        return view('issues.index', compact('issues','tags','projects'));
    }

    public function create() {
        return view('issues.create', [
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function store(StoreIssueRequest $request) {
        $issue = Issue::create($request->validated());
        return redirect()->route('issues.show',$issue)->with('success','Issue created');
    }

    public function show(Issue $issue) {
        $issue->load(['project','tags','members']);
        return view('issues.show', compact('issue'));
    }

    public function edit(Issue $issue) { return view('issues.edit', compact('issue')); }
    public function update(UpdateIssueRequest $request, Issue $issue) {
        $issue->update($request->validated());
        return redirect()->route('issues.show',$issue)->with('success','Updated');
    }

    public function destroy(Issue $issue) {
        $issue->delete();
        return redirect()->route('issues.index')->with('success','Deleted');
    }

    public function attachMember(Request $request, Issue $issue)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $issue->members()->syncWithoutDetaching($user);
        $html = view('members.member', ['member' => $user])->render();


        return response()->json(['ok' => true, 'html' => $html]);
    }

    public function detachMember(Issue $issue, User $user)
    {
        $issue->members()->detach($user);

        return response()->json(['ok' => true]);
    }
    public function attachTag(Request $request, Issue $issue)
    {
        $issue->tags()->attach($request->tag_id);

        $tag = Tag::find($request->tag_id);

        $html = view('tags.show', compact('tag'))->render();

        return response()->json(['ok' => true, 'html' => $html]);
    }

    public function detachTag(Issue $issue, Tag $tag)
    {
        $issue->tags()->detach($tag->id);

        return response()->json(['ok' => true]);
    }

}
