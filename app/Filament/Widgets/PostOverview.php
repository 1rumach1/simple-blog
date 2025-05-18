<?php

namespace App\Filament\Widgets;

use App\Http\Livewire\UpvoteDownvote;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostView;

class PostOverview extends Widget
{
    protected int | string | array $columnSpan = 3;

    public ?Model $records = null;

    protected function getViewData(): array
    {
        $postId = $this->records?->id;

        return [
            'viewCount' => $postId ? PostView::where("post_id", '=', $postId)->count() : 0,
            'upvotes' => $postId ? UpvoteDownvote::where("post_id", '=', $postId)->where('is_upvote', '=', true)->count() : 0,
            'downvotes' => $postId ? UpvoteDownvote::where("post_id", '=', $postId)->where('is_upvote', '=', false)->count() : 0,
        ];
    }
    protected static string $view = 'filament.widgets.post-overview';
}
