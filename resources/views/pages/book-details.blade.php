@extends('layouts.app')

@section('title', $book['title'] . ' - ' . __('app.name'))

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-muted-foreground hover:text-primary transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('app.common.back') }}
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Book Cover and Basic Info -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <div class="bg-background border rounded-lg p-6">
                        <!-- Book Cover -->
                        <div class="aspect-[3/4] w-full max-w-xs mx-auto mb-6">
                            @if(isset($book['cover_url']) && $book['cover_url'])
                                <img src="{{ $book['cover_url'] }}" 
                                     alt="{{ $book['title'] }}" 
                                     class="w-full h-full object-cover rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-full bg-muted rounded-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Add to Library Button -->
                        @auth
                            <form method="POST" action="{{ route('library.add') }}" class="mb-4">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book['id'] }}">
                                <input type="hidden" name="book_source" value="{{ $source }}">
                                <input type="hidden" name="book_title" value="{{ $book['title'] }}">
                                <input type="hidden" name="book_authors" value="{{ implode(', ', $book['authors'] ?? []) }}">
                                <input type="hidden" name="book_image" value="{{ $book['cover_url'] ?? '' }}">
                                
                                <button type="submit" 
                                        class="w-full bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('app.books.actions.addToLibrary') }}
                                </button>
                            </form>
                        @else
                            <div class="text-center mb-4">
                                <p class="text-sm text-muted-foreground mb-3">
                                    {{ __('app.books.actions.loginToAdd') }}
                                </p>
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors">
                                    {{ __('app.navigation.login') }}
                                </a>
                            </div>
                        @endauth

                        <!-- External Links -->
                        @if(isset($book['preview_url']) && $book['preview_url'])
                            <a href="{{ $book['preview_url'] }}" 
                               target="_blank" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                {{ __('app.books.actions.preview') }}
                            </a>
                        @endif

                        @if(isset($book['info_url']) && $book['info_url'])
                            <a href="{{ $book['info_url'] }}" 
                               target="_blank" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('app.books.actions.more_info') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:col-span-2">
                <div class="bg-background border rounded-lg p-6">
                    <!-- Title and Authors -->
                    <h1 class="text-3xl font-bold text-foreground mb-4">{{ $book['title'] }}</h1>
                    
                    @if(isset($book['authors']) && count($book['authors']) > 0)
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-foreground mb-2">{{ __('app.books.details.authors') }}</h2>
                            <p class="text-muted-foreground">{{ implode(', ', $book['authors']) }}</p>
                        </div>
                    @endif

                    <!-- Book Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @if(isset($book['publisher']) && $book['publisher'])
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">{{ __('app.books.details.publisher') }}</h3>
                                <p class="text-muted-foreground">{{ $book['publisher'] }}</p>
                            </div>
                        @endif

                        @if(isset($book['published_date']) && $book['published_date'])
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">{{ __('app.books.details.published') }}</h3>
                                <p class="text-muted-foreground">{{ $book['published_date'] }}</p>
                            </div>
                        @endif

                        @if(isset($book['page_count']) && $book['page_count'])
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">{{ __('app.books.details.pages') }}</h3>
                                <p class="text-muted-foreground">{{ $book['page_count'] }} {{ __('app.books.info.pages') }}</p>
                            </div>
                        @endif

                        @if(isset($book['isbn']) && $book['isbn'])
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">{{ __('app.books.details.isbn') }}</h3>
                                <p class="text-muted-foreground font-mono text-sm">{{ $book['isbn'] }}</p>
                            </div>
                        @endif

                        @if(isset($book['rating']) && $book['rating'])
                            <div>
                                <h3 class="font-semibold text-foreground mb-1">{{ __('app.books.details.rating') }}</h3>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $book['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-muted-foreground">
                                        {{ number_format($book['rating'], 1) }} 
                                        ({{ $book['reviews_count'] ?? 0 }} {{ __('app.books.info.reviews') }})
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Categories -->
                    @if(isset($book['categories']) && count($book['categories']) > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-foreground mb-2">{{ __('app.books.details.categories') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book['categories'] as $category)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-secondary text-secondary-foreground">
                                        {{ $category }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if(isset($book['description']) && $book['description'])
                        <div>
                            <h3 class="font-semibold text-foreground mb-3">{{ __('app.books.details.description') }}</h3>
                            <div class="prose prose-sm max-w-none text-muted-foreground">
                                {!! nl2br(e($book['description'])) !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-muted-foreground">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>{{ __('app.books.info.noDescription') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
