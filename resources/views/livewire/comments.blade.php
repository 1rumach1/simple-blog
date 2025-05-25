<div class="space-y-6 bg-white p-4 rounded-lg shadow">
    {{-- Create New Comment --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Leave a Comment</h3>
        <livewire:comment-create :post="$post" />
    </div>

    {{-- Comment List --}}
    <div class="space-y-4">
        @foreach($comments as $comment)
            <livewire:comment-item
                :comment="$comment"
                wire:key="comment-{{$comment->id}}-{{$comment->comments->count()}}"
            />
        @endforeach
    </div>

    {{-- Load More --}}
    @if($hasMore)
        <div class="text-center mt-4">
            <button wire:click="loadMore"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500 transition">
                <span wire:loading.remove>Load More Comments</span>
                <span wire:loading>Loading...</span>
            </button>
        </div>
    @endif
</div>


