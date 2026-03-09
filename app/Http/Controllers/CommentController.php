<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */


    public static function middleware() {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index(Post $post)
    {

        $comments = $post->comments->filter(function ($comment) use ($post) {
            return !$comment->flagged_at || Auth::id() === $post->user_id;
        });
        return response()->json([
            'post_id' => $post->id,
            'comments' => $comments->values()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request, Post $post)
    {
        $fields = $request->validate([
            'body' => 'required|max:255'
        ]);

        $comment = $request->user()->comments()->create([
            'body' => $fields['body'],
            'post_id' => $post->id
        ]);

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $post->load('comments');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('modify', $comment);
        $fields = $request->validate([
            'body' => 'required|max:255'
        ]);

        $comment->update($fields);

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('modify', $comment);
        $comment->delete();
        return ['message' => "The comment ($comment->id) has been deleted"];
    }

    public function flag(Comment $comment) {
        Gate::authorize('flagcomment',$comment);

        $comment->update([
        'flagged_at' => now()
        ]);

    return response()->json([
        'message' => 'Comment flagged successfully',
        'comment' => $comment
    ]);
    }
}
