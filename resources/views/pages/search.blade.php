@extends('layouts.app')

@section('title', __('app.search.title') . ' - ' . __('app.name'))
@section('description', __('app.search.subtitle'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('app.search.title') }}
            </h1>
            <p class="text-lg text-muted-foreground">
                {{ __('app.search.subtitle') }}
            </p>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('search') }}" class="space-y-4">
            <div class="flex gap-2">
                <div class="flex-1">
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}"
                           placeholder="{{ __('app.search.placeholder') }}"
                           class="w-full h-12 text-lg px-4 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent">
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-primary-foreground rounded-md hover:bg-primary/90 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Search Options -->
            <div class="flex flex-wrap gap-4 items-center">
                <select name="type" class="w-40 px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="general" {{ request('type', 'general') === 'general' ? 'selected' : '' }}>{{ __('app.search.types.general') }}</option>
                    <option value="title" {{ request('type') === 'title' ? 'selected' : '' }}>{{ __('app.search.types.title') }}</option>
                    <option value="author" {{ request('type') === 'author' ? 'selected' : '' }}>{{ __('app.search.types.author') }}</option>
                    <option value="isbn" {{ request('type') === 'isbn' ? 'selected' : '' }}>{{ __('app.search.types.isbn') }}</option>
                    <option value="subject" {{ request('type') === 'subject' ? 'selected' : '' }}>{{ __('app.search.types.subject') }}</option>
                </select>

                <select name="language" class="w-32 px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="all" {{ request('language', 'all') === 'all' ? 'selected' : '' }}>{{ __('app.search.languages.all') }}</option>
                    <option value="es" {{ request('language') === 'es' ? 'selected' : '' }}>{{ __('app.search.languages.es') }}</option>
                    <option value="en" {{ request('language') === 'en' ? 'selected' : '' }}>{{ __('app.search.languages.en') }}</option>
                    <option value="fr" {{ request('language') === 'fr' ? 'selected' : '' }}>{{ __('app.search.languages.fr') }}</option>
                    <option value="de" {{ request('language') === 'de' ? 'selected' : '' }}>{{ __('app.search.languages.de') }}</option>
                    <option value="it" {{ request('language') === 'it' ? 'selected' : '' }}>{{ __('app.search.languages.it') }}</option>
                </select>

                <select name="sort" class="w-32 px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="relevance" {{ request('sort', 'relevance') === 'relevance' ? 'selected' : '' }}>{{ __('app.search.sorting.relevance') }}</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('app.search.sorting.newest') }}</option>
                </select>
            </div>
        </form>

        <!-- Quick Searches -->
        @if(empty($query))
        <div class="mt-6">
            <p class="text-sm text-muted-foreground mb-3">{{ __('app.search.popular_searches') }}</p>
            <div class="flex flex-wrap gap-2">
                @php
                    $quickSearches = [
                        'ficción contemporánea',
                        'bestsellers 2024',
                        'ciencia ficción',
                        'novela histórica',
                        'autoayuda',
                        'biografías',
                        'thriller psicológico',
                        'literatura clásica'
                    ];
                @endphp
                @foreach($quickSearches as $search)
                <a href="{{ route('search', ['q' => $search]) }}" 
                   class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary text-secondary-foreground hover:bg-secondary/80 transition-colors">
                    {{ $search }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Results -->
    @if(!empty($query))
    <div class="max-w-7xl mx-auto">
        <!-- Results Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <p class="text-sm text-muted-foreground">
                    {{ number_format($totalResults) }} {{ __('app.search.results.found', ['count' => $totalResults, 'query' => $query]) }}
                </p>
                @if(count($books) > 0)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border border-input bg-background text-foreground">
                    {{ __('app.search.results.showing', ['current' => count($books), 'total' => number_format($totalResults)]) }}
                </span>
                @endif
            </div>
        </div>

        <!-- Books Grid -->
        @if(count($books) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
            @php
                $inLibrary = isset($book['in_library']) && $book['in_library'];
                if (!$inLibrary && auth()->check() && isset($userBookIds[$book['source'] ?? ''])) {
                    $inLibrary = $userBookIds[$book['source']] == $book['id'];
                }
            @endphp
            <div class="group hover:shadow-lg transition-all duration-200 border rounded-lg overflow-hidden flex flex-col {{ $inLibrary ? 'ring-2 ring-green-500/50' : '' }}">
                @if($inLibrary)
                <div class="bg-green-500 text-white px-3 py-1.5 text-xs font-medium flex items-center justify-between">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('app.books.in_library') }}
                    </span>
                    @if(isset($book['user_status']))
                    <span class="text-xs opacity-90">{{ __('app.books.categories.' . str_replace('-', '_', $book['user_status'])) }}</span>
                    @endif
                </div>
                @endif
                <div class="p-4 flex space-x-3 flex-1">
                    <!-- Book Cover -->
                    <div class="w-16 h-24 md:w-20 md:h-28 rounded-md overflow-hidden bg-muted flex-shrink-0">
                        @if(isset($book['cover_url']) && $book['cover_url'])
                        <img src="{{ $book['cover_url'] }}" alt="{{ $book['title'] }}" class="w-full h-full object-cover">
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
                            {{ $book['title'] ?? 'Título no disponible' }}
                        </h3>
                        
                        @if(isset($book['authors']) && count($book['authors']) > 0)
                        <p class="text-sm text-muted-foreground mb-2">
                            {{ implode(', ', $book['authors']) }}
                        </p>
                        @endif

                        <!-- Rating -->
                        @if(isset($book['rating']) && $book['rating'] > 0)
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($book['rating']))
                                        <svg class="h-3 w-3 fill-yellow-400 text-yellow-400" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="h-3 w-3 text-gray-300" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-muted-foreground">
                                ({{ $book['rating'] }}) · {{ $book['reviews_count'] ?? 0 }} {{ __('app.books.info.reviews') }}
                            </span>
                        </div>
                        @endif

                        <!-- Description -->
                        @if(isset($book['description']))
                        <p class="text-xs text-muted-foreground line-clamp-2 mb-2">
                            {{ Str::limit($book['description'], 100) }}
                        </p>
                        @endif

                        <!-- Metadata -->
                        <div class="flex items-center space-x-3 text-xs text-muted-foreground">
                            @if(isset($book['published_date']))
                            <span>{{ date('Y', strtotime($book['published_date'])) }}</span>
                            @endif
                            @if(isset($book['page_count']) && $book['page_count'] > 0)
                            <span>{{ $book['page_count'] }} {{ __('app.books.info.pages') }}</span>
                            @endif
                            @if(isset($book['language']))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border border-input bg-background text-foreground">
                                {{ strtoupper($book['language']) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons - Full width at bottom -->
                <div class="border-t p-3 flex gap-2">
                    <a href="{{ route('book.details', ['source' => $book['source'], 'id' => $book['id']]) }}" 
                       class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('app.books.actions.view_details') }}
                    </a>
                    
                    @auth
                        @if($inLibrary)
                            <a href="{{ route('library') }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white hover:bg-green-700 rounded-md text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('app.books.in_library') }}
                            </a>
                        @else
                            <form method="POST" action="{{ route('library.add') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book['id'] }}">
                                <input type="hidden" name="book_source" value="{{ $book['source'] }}">
                                <input type="hidden" name="book_title" value="{{ $book['title'] }}">
                                <input type="hidden" name="book_authors" value="{{ implode(', ', $book['authors'] ?? []) }}">
                                <input type="hidden" name="book_image" value="{{ $book['cover_url'] ?? '' }}">
                                <input type="hidden" name="book_description" value="{{ $book['description'] ?? '' }}">
                                <input type="hidden" name="book_publisher" value="{{ $book['publisher'] ?? '' }}">
                                <input type="hidden" name="book_published_date" value="{{ $book['published_date'] ?? '' }}">
                                <input type="hidden" name="book_page_count" value="{{ $book['page_count'] ?? '' }}">
                                <input type="hidden" name="book_isbn" value="{{ $book['isbn'] ?? '' }}">
                                <input type="hidden" name="book_rating" value="{{ $book['rating'] ?? '' }}">
                                <input type="hidden" name="book_categories" value="{{ implode(', ', $book['categories'] ?? []) }}">
                                <input type="hidden" name="book_preview_url" value="{{ $book['preview_url'] ?? '' }}">
                                <input type="hidden" name="book_info_url" value="{{ $book['info_url'] ?? '' }}">
                                
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-primary text-primary-foreground hover:bg-primary/90 rounded-md text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('app.books.actions.add_to_library') }}
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-primary text-primary-foreground hover:bg-primary/90 rounded-md text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('app.navigation.login') }}
                        </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- No Results -->
        <div class="max-w-md mx-auto text-center py-12">
            <svg class="h-16 w-16 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-lg font-semibold mb-2">{{ __('app.search.results.no_results') }}</h3>
            <p class="text-muted-foreground mb-4">
                {{ __('app.search.results.no_results_desc') }}
            </p>
            <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                {{ __('app.search.results.clear_search') }}
            </a>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
