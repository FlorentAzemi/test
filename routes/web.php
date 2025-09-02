<?php

use App\Http\Controllers\{
    ProfileController,
    ProjectController,
    IssueController,
    TagController,
    CommentController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
    Route::resource('issues', IssueController::class);
    Route::resource('tags', TagController::class)->only(['index','store']); 

    Route::post('/issues/{issue}/tags', [IssueController::class,'attachTag'])->name('issues.tags.attach');
    Route::delete('/issues/{issue}/tags/{tag}', [IssueController::class,'detachTag'])->name('issues.tags.detach');

    Route::get('/issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments.index');

Route::prefix('issues/{issue}')->group(function () {
    Route::get('comments', [CommentController::class, 'index'])->name('issues.comments.index');
    Route::post('comments', [CommentController::class, 'store'])->name('issues.comments.store');
});



Route::post('/issues/{issue}/members', [IssueController::class, 'attachMember'])->name('issues.members.attach');
Route::delete('/issues/{issue}/members/{user}', [IssueController::class, 'detachMember'])->name('issues.members.detach');

});

require __DIR__.'/auth.php';
