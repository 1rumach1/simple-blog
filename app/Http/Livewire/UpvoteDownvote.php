<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class UpvoteDownvote extends Component
{
    public Post $post;
    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $upvotes = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', true)
            ->count();

        $downvotes = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', false)
            ->count();

        $hasUpvoted = null;

        /** @var \App\Models\User $user */
        $user = request()->user();

        if ($user) {
            $status = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
                ->where('user_id', '=', $user->id)
                ->first();
            if ($status) {
                $hasUpvoted = !!$status->is_upvote;
            }
        }

        return view('livewire.upvote-downvote', compact('upvotes', 'downvotes', 'hasUpvoted'));
    }

    public function upvoteDownvote($upvote = true)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        if (!$user) {
            return $this->redirect(url('login'));
        }

        if (!$user->hasVerifiedEmail()) {
            return $this->redirect(route('verification.notice'));
        }

        $upvoteDownvote = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if (!$upvoteDownvote) {
            \App\Models\UpvoteDownvote::create([
                'is_upvote' => $upvote,
                'post_id' => $this->post->id,
                'user_id' => $user->id,
            ]);
            return;
        }

        if (($upvote && $upvoteDownvote->is_upvote) || (!$upvote && !$upvoteDownvote->is_upvote)) {
            $upvoteDownvote->delete();
        } else {
            $upvoteDownvote->is_upvote = $upvote;
            $upvoteDownvote->save();
        }
    }
}
