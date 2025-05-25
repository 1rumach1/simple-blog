<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Category;
use App\Models\PostView;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(): View
    {
        //Latest Post
        $latestPosts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', "<", Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        //Popular post based on upvotes
        $uD = 'upvote_downvotes';
        $popularPosts = Post::query()
            ->leftJoin($uD, 'posts.id', '=', $uD . '.post_id')
            ->select('posts.*', DB::raw("COUNT({$uD}.id) as upvote_count"))
            ->where(function ($query) use ($uD) {
                $query->whereNull($uD . '.is_upvote')
                    ->orWhere($uD . '.is_upvote', true);
            })->where('active', 1)
            ->whereDate('published_at', "<", Carbon::now())
            ->orderBy('upvote_count', 'desc')
            ->groupBy('posts.id')
            ->limit(3)
            ->get();

        //if authorized recomendations based on upvotes anf view count ! authorized
        $user = auth()->user();
        if ($user) {
            $LeftJoin = "(SELECT cp.category_id, cp.post_id FROM upvote_downvotes
                          JOIN category_post cp ON upvote_downvotes.post_id = cp.post_id
                          WHERE upvote_downvotes.is_upvote = 1 and upvote_downvotes.user_id = ?) as t";

            $recommendedPosts = Post::query()
                ->leftJoin('category_post as cp', 'posts.id', '=', 'cp.post_id')
                ->leftJoin(DB::raw($LeftJoin), function ($join) {
                    $join->on('t.category_id', '=', 'cp.category_id')
                        ->on('posts.id', '<>', DB::raw('t.post_id'));
                })
                ->select('posts.*')
                ->setBindings([$user->id])
                ->limit(3)
                ->get();
        } else {
            $pD = 'post_views';
            $recommendedPosts = Post::query()
                ->leftJoin($pD, 'posts.id', '=', $pD . '.post_id')
                ->select('posts.*', DB::raw("COUNT({$pD}.id) as view_count"))
                ->where('active', 1)
                ->whereDate('published_at', "<", Carbon::now())
                ->orderBy('view_count', 'desc')
                ->groupBy('posts.id')
                ->limit(5)
                ->get();
        }

        // posts from categories
        $categoriesPost = Category::query()
            // ->with(['posts' => function ($query) {
            //     $query->orderByDesc('published_at');
            // }])
            ->select('categories.*') // 'columns' here looks like a placeholder or typo
            ->selectRaw('MAX(posts.published_at) as max_date')
            ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
            ->leftJoin('posts', 'posts.id', '=', 'category_post.post_id')
            ->orderByDesc('max_date')
            ->groupBy('categories.id')
            ->limit(5)
            ->get();

        // $posts = Post::query()
        //     ->where('active', 1)
        //     ->whereDate('published_at', "<", Carbon::now())
        //     ->orderBy('published_at', 'desc')
        //     ->paginate(10);

        return view('home', compact('latestPosts', 'popularPosts', 'recommendedPosts', 'categoriesPost'));
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

        return view('home2', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function getThumbnail(Post $post)
    {
        return $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('thumbnails/default-thumbnail.jpg');
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $posts = Post::query()
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%");
            })
            ->paginate(10);

        return view('post.search', compact('posts'));
    }
}
