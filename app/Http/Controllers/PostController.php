<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Category;
use App\Models\PostView;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(): View
    {
        $posts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', "<", Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('home', compact('posts'));
    }


    public function show(Post $post, Request $request)
    {
        abort_unless($post->active && $post->published_at <= now(), 404);

        $next = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $prev = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();

        $user = $request->user();
        $userId = $user ? $user->id : null;
        $ipAddress = $request->ip();

        $existingView = PostView::where('post_id', $post->id)
            ->where(function ($query) use ($userId, $ipAddress) {
                $query->where('ip_address', $ipAddress);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        // Only create a new view record if no recent view exists
        if (!$existingView) {
            PostView::create([
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'post_id' => $post->id,
                'user_id' => $userId,
            ]);
        }

        return view('post.view', [
            'post' => $post,
            'next' => $next,
            'prev' => $prev,
        ]);
    }

    public function byCategory(Category $category)
    {
        $posts = Post::query()
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('category_post.category_id', '=', $category->id)
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('home', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function getThumbnail(Post $post)
    {
        return $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('thumbnails/default-thumbnail.jpg');
    }
}
