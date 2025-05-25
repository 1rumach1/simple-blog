<div class="flex gap-3">
    {{-- Avatar Placeholder --}}
    <div class="flex-shrink-0">
        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.93 17.93 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
            </svg>
        </div>
    </div>

    {{-- Comment Content --}}
    <div class="flex-1">
        <div class="mb-1 text-sm text-gray-700">
            <span class="font-semibold text-indigo-600">{{ $comment->user->name }}</span>
            <span class="text-gray-400 text-xs">· {{ $comment->created_at->diffForHumans() }}</span>
        </div>

        @if($editing)
            <livewire:comment-create :comment-model="$comment" />
        @else
            <div class="text-gray-800 mb-2">{{ $comment->comment }}</div>
        @endif

        <div class="text-sm text-gray-500 space-x-3">
            <a wire:click.prevent="startReply" href="#" class=" text-green-900 hover:underline">Reply</a>
            @if (Auth::id() == $comment->user_id)
                <a wire:click.prevent="startCommentEdit" href="#" class="hover:underline text-blue-600">Edit</a>
                <a wire:click.prevent="deleteComment" href="#" class="hover:underline text-red-600">Delete</a>
            @endif
        </div>

        @if ($replying)
            <div class="mt-2">
                <livewire:comment-create :post="$comment->post" :parent-comment="$comment" />
            </div>
        @endif

        @if ($comment->comments->count())
            <div class="pl-6 mt-4 border-l border-gray-200 space-y-4">
                @foreach($comment->comments as $childComment)
                    <livewire:comment-item :comment="$childComment" wire:key="comment-{{$childComment->id}}" />
                @endforeach
            </div>
        @endif
    </div>
</div>
