<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FlagPolicy
{
    public function flagcomment(User $user, Comment $comment): Response
    {
        return $user->id === $comment->post->user_id ? Response::allow() : Response::deny("You do not own this post");
    }
}