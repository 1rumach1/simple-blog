<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;
    public int $perPage = 5;

    protected $listeners = [
        'commentCreated' => '$refresh',
        'commentDeleted' => '$refresh',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function render()
    {
        $comments = $this->selectComments();
        $hasMore = Comment::where('post_id', $this->post->id)
            ->whereNull('parent_id')
            ->count() > $comments->count();

        return view('livewire.comments', compact('comments', 'hasMore'));
    }

    private function selectComments()
    {
        return Comment::where('post_id', $this->post->id)
            ->with(['post', 'user', 'comments'])
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->take($this->perPage)
            ->get();
    }
}
