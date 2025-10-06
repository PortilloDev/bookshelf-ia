@extends('layouts.app')

@section('title', __('app.dashboard.welcome', ['name' => $user->name]) . ' - ' . __('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">
            {{ __('app.dashboard.welcome', ['name' => $user->name]) }}
        </h1>
        <p class="text-muted-foreground">
            {{ __('app.dashboard.subtitle') }}
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="border rounded-lg p-6">
            <div class="flex items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">{{ __('app.dashboard.stats.total_books') }}</h3>
                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $stats['totalBooks'] }}</div>
            <p class="text-xs text-muted-foreground">
                {{ __('app.dashboard.stats.total_books_desc') }}
            </p>
        </div>

        <div class="border rounded-lg p-6">
            <div class="flex items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">{{ __('app.dashboard.stats.read_books') }}</h3>
                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $stats['readBooks'] }}</div>
            <p class="text-xs text-muted-foreground">
                {{ __('app.dashboard.stats.read_books_desc') }}
            </p>
        </div>

        <div class="border rounded-lg p-6">
            <div class="flex items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">{{ __('app.dashboard.stats.reading_now') }}</h3>
                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $stats['readingBooks'] }}</div>
            <p class="text-xs text-muted-foreground">
                {{ __('app.dashboard.stats.reading_now_desc') }}
            </p>
        </div>

        <div class="border rounded-lg p-6">
            <div class="flex items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">{{ __('app.dashboard.stats.favorites') }}</h3>
                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $stats['favoriteBooks'] }}</div>
            <p class="text-xs text-muted-foreground">
                {{ __('app.dashboard.stats.favorites_desc') }}
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="border rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">{{ __('app.dashboard.recent_activity.title') }}</h3>
            @if(count($recentBooks) === 0)
            <div class="text-center py-8">
                <svg class="h-12 w-12 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h4 class="font-semibold mb-2">{{ __('app.dashboard.recent_activity.empty.title') }}</h4>
                <p class="text-sm text-muted-foreground mb-4">
                    {{ __('app.dashboard.recent_activity.empty.description') }}
                </p>
                <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('app.dashboard.recent_activity.empty.action') }}
                </a>
            </div>
            @else
            <div class="space-y-4">
                @foreach($recentBooks as $book)
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-12 bg-muted rounded flex-shrink-0">
                        @if(!empty($book['cover_url']))
                        <img src="{{ $book['cover_url'] }}" alt="{{ $book['title'] }}" class="w-full h-full object-cover rounded">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ $book['title'] }}</p>
                        <p class="text-xs text-muted-foreground mb-1">
                            {{ implode(', ', $book['authors'] ?? []) }}
                        </p>
                        <div class="flex flex-wrap gap-1">
                            @if(!empty($book['shelves']))
                                @foreach($book['shelves'] as $shelf)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background-color: {{ $shelf['color'] }}22; color: {{ $shelf['color'] }}; border: 1px solid {{ $shelf['color'] }}">
                                    @if(!empty($shelf['icon'])){{ $shelf['icon'] }}@endif {{ $shelf['name'] }}
                                </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="border rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">{{ __('app.dashboard.quick_actions.title') }}</h3>
            <div class="space-y-4">
                <a href="{{ route('search') }}" class="flex items-center w-full px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    {{ __('app.dashboard.quick_actions.search_books') }}
                </a>
                
                <a href="{{ route('library') }}" class="flex items-center w-full px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    {{ __('app.dashboard.quick_actions.view_library') }}
                </a>
                
                <a href="{{ route('import') }}" class="flex items-center w-full px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('app.dashboard.quick_actions.import_excel') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
