@extends('layouts.app')

@section('title', __('app.library.title') . ' - ' . __('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ __('app.library.title') }}</h1>
            <p class="text-muted-foreground">
                {{ __('app.library.subtitle', ['count' => count($userBooks)]) }}
            </p>
        </div>
        
        <div class="flex items-center space-x-2">
            <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('app.library.add_books') }}
            </a>
            <a href="{{ route('import') }}" class="inline-flex items-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                {{ __('app.library.import_excel') }}
            </a>
        </div>
    </div>

    @if(count($userBooks) === 0)
    <!-- Empty State -->
    <div class="max-w-md mx-auto">
        <div class="border rounded-lg p-12 text-center">
            <svg class="h-16 w-16 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-lg font-semibold mb-2">{{ __('app.library.empty.title') }}</h3>
            <p class="text-muted-foreground mb-6">
                {{ __('app.library.empty.description') }}
            </p>
            <div class="space-y-2">
                <a href="{{ route('search') }}" class="block w-full px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors">
                    <svg class="inline mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    {{ __('app.library.empty.search_books') }}
                </a>
                <a href="{{ route('import') }}" class="block w-full px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                    <svg class="inline mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    {{ __('app.library.empty.import_excel') }}
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Search and Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-1">
            <form method="GET" action="{{ route('library') }}">
                <input type="text" 
                       name="search" 
                       value="{{ $searchQuery }}"
                       placeholder="{{ __('app.library.search_placeholder') }}"
                       class="w-full h-10 px-3 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent">
            </form>
        </div>
        
        <select name="category" class="w-48 px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
            <option value="all">{{ __('app.library.all_categories', ['count' => count($userBooks)]) }}</option>
            @foreach($categories as $category)
            <option value="{{ $category['id'] }}" {{ $category === $category['id'] ? 'selected' : '' }}>
                {{ $category['icon'] }} {{ $category['name'] }} ({{ $category['count'] ?? 0 }})
            </option>
            @endforeach
        </select>
    </div>

    <!-- Category Tabs -->
    <div class="mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-2">
            <a href="{{ route('library', ['category' => 'all']) }}" 
               class="flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md {{ $category === 'all' ? 'bg-primary text-primary-foreground' : 'bg-background text-foreground hover:bg-accent hover:text-accent-foreground' }} transition-colors">
                {{ __('app.library.all_categories', ['count' => count($userBooks)]) }}
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('library', ['category' => $cat['id']]) }}" 
               class="hidden lg:flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md {{ $category === $cat['id'] ? 'bg-primary text-primary-foreground' : 'bg-background text-foreground hover:bg-accent hover:text-accent-foreground' }} transition-colors">
                {{ $cat['icon'] }} {{ $cat['name'] }} ({{ $cat['count'] ?? 0 }})
            </a>
            @endforeach
        </div>
    </div>

    <!-- Results -->
    @if(count($userBooks) === 0)
    <div class="border rounded-lg p-12 text-center">
        <svg class="h-12 w-12 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <h3 class="text-lg font-semibold mb-2">{{ __('app.library.no_results.title') }}</h3>
        <p class="text-muted-foreground">
            @if($searchQuery)
                {{ __('app.library.no_results.by_search') }}
            @else
                {{ __('app.library.no_results.by_category') }}
            @endif
        </p>
        @if($searchQuery)
        <a href="{{ route('library') }}" class="inline-flex items-center mt-4 px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
            {{ __('app.library.no_results.clear_search') }}
        </a>
        @endif
    </div>
    @else
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-muted-foreground">
            {{ count($userBooks) }} {{ __('app.library.results.books', ['count' => count($userBooks)]) }}
            @if($searchQuery)
                {{ __('app.library.results.found', ['count' => count($userBooks), 'query' => $searchQuery]) }}
            @endif
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($userBooks as $userBook)
        <div class="group hover:shadow-lg transition-all duration-200 border rounded-lg p-4">
            <div class="flex space-x-3">
                <!-- Book Cover -->
                <div class="w-16 h-24 md:w-20 md:h-28 rounded-md overflow-hidden bg-muted flex-shrink-0">
                    @if($userBook->book->cover_url)
                    <img src="{{ $userBook->book->cover_url }}" alt="{{ $userBook->book->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-muted to-muted/50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Book Info -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-sm md:text-base line-clamp-2 mb-1">
                        {{ $userBook->book->title }}
                    </h3>
                    
                    @if($userBook->book->authors && count($userBook->book->authors) > 0)
                    <p class="text-sm text-muted-foreground mb-2">
                        {{ implode(', ', $userBook->book->authors) }}
                    </p>
                    @endif

                    <!-- Category Badge -->
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary">
                        {{ $userBook->status }}
                    </span>

                    <!-- Notes -->
                    @if($userBook->notes)
                    <p class="text-xs text-muted-foreground mt-2 line-clamp-2">
                        {{ $userBook->notes }}
                    </p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-2 mt-3">
                        <a href="{{ route('book.details', ['source' => $userBook->book->source, 'id' => $userBook->book->external_id]) }}" 
                           class="flex-1 inline-flex items-center justify-center px-2 py-1 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-xs font-medium transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ __('app.books.actions.view_details') }}
                        </a>
                        
                        <button onclick="openEditModal({{ $userBook->id }}, '{{ $userBook->notes }}', '{{ $userBook->status }}', {{ $userBook->user_rating ?? 'null' }})" 
                                class="flex-1 inline-flex items-center justify-center px-2 py-1 bg-primary text-primary-foreground hover:bg-primary/90 rounded-md text-xs font-medium transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('app.books.actions.edit') }}
                        </button>
                    </div>

                    <!-- Metadata -->
                    <div class="flex items-center space-x-3 text-xs text-muted-foreground mt-2">
                        <span>{{ __('app.books.added') }}: {{ $userBook->created_at->format('M Y') }}</span>
                        @if($userBook->user_rating)
                        <span>{{ __('app.books.info.rating') }}: {{ $userBook->user_rating }}/5</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endif
</div>

<!-- Edit Book Modal -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-background rounded-lg shadow-xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('app.books.actions.edit') }}</h3>
                    
                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('app.books.categories.title') }}</label>
                        <select name="status" class="w-full px-3 py-2 border border-input rounded-md">
                            <option value="to-read">{{ __('app.books.categories.to_read') }}</option>
                            <option value="reading">{{ __('app.books.categories.reading') }}</option>
                            <option value="read">{{ __('app.books.categories.read') }}</option>
                            <option value="favorites">{{ __('app.books.categories.favorites') }}</option>
                            <option value="wishlist">{{ __('app.books.categories.wishlist') }}</option>
                        </select>
                    </div>
                    
                    <!-- User Rating -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('app.books.actions.rating') }}</label>
                        <select name="user_rating" class="w-full px-3 py-2 border border-input rounded-md">
                            <option value="">{{ __('app.books.actions.no_rating') }}</option>
                            <option value="1">1 ⭐</option>
                            <option value="2">2 ⭐⭐</option>
                            <option value="3">3 ⭐⭐⭐</option>
                            <option value="4">4 ⭐⭐⭐⭐</option>
                            <option value="5">5 ⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    
                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">{{ __('app.books.actions.notes') }}</label>
                        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-input rounded-md" placeholder="{{ __('app.books.actions.notes_placeholder') }}"></textarea>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                            {{ __('app.common.cancel') }}
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-primary text-primary-foreground hover:bg-primary/90 rounded-md text-sm font-medium transition-colors">
                            {{ __('app.common.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(userBookId, notes, status, rating) {
    const modal = document.getElementById('editModal');
    const modalContent = document.getElementById('modalContent');
    const form = document.getElementById('editForm');
    
    // Set form action
    form.action = `/library/${userBookId}/update`;
    
    // Set form values
    form.querySelector('select[name="status"]').value = status;
    form.querySelector('select[name="user_rating"]').value = rating || '';
    form.querySelector('textarea[name="notes"]').value = notes || '';
    
    // Show modal with animation
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const modalContent = document.getElementById('modalContent');
    
    // Animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    // Hide modal after animation
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('editModal');
        if (!modal.classList.contains('hidden')) {
            closeEditModal();
        }
    }
});
</script>
@endsection
