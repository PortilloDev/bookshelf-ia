@extends('layouts.app')

@section('title', __('app.name') . ' - ' . __('app.tagline'))
@section('description', __('app.landing.hero.subtitle'))

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-background to-secondary/5"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border border-input bg-background mb-6">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('app.tagline') }}
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-primary to-primary/70 bg-clip-text text-transparent">
                    {{ __('app.landing.hero.title') }}
                </h1>
                
                <p class="text-xl md:text-2xl text-muted-foreground mb-8 max-w-2xl mx-auto">
                    {{ __('app.landing.hero.subtitle') }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-primary-foreground rounded-md text-lg font-medium hover:bg-primary/90 transition-colors w-full sm:w-auto">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('app.landing.hero.start_free') }}
                    </a>
                    
                    <a href="{{ route('search') }}" class="inline-flex items-center justify-center px-6 py-3 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-lg font-medium transition-colors w-full sm:w-auto">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('app.landing.hero.explore_books') }}
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-primary/10 rounded-lg mb-3">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-primary">1M+</div>
                        <div class="text-sm text-muted-foreground">{{ __('app.landing.stats.books_available') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-primary/10 rounded-lg mb-3">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-primary">50K+</div>
                        <div class="text-sm text-muted-foreground">{{ __('app.landing.stats.active_users') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-primary/10 rounded-lg mb-3">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-primary">200K+</div>
                        <div class="text-sm text-muted-foreground">{{ __('app.landing.stats.reviews_written') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-primary/10 rounded-lg mb-3">
                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-primary">75K+</div>
                        <div class="text-sm text-muted-foreground">{{ __('app.landing.stats.lists_created') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-muted/30">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    {{ __('app.landing.features.title') }}
                </h2>
                <p class="text-lg text-muted-foreground">
                    {{ __('app.landing.features.subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.organize.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.organize.description') }}
                    </p>
                </div>

                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.search.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.search.description') }}
                    </p>
                </div>

                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-red-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.notes.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.notes.description') }}
                    </p>
                </div>

                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-purple-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.import.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.import.description') }}
                    </p>
                </div>

                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-orange-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.stats.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.stats.description') }}
                    </p>
                </div>

                <div class="group hover:shadow-lg transition-all duration-300 border-0 bg-background/60 backdrop-blur rounded-lg p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-background mb-4 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('app.landing.features.community.title') }}</h3>
                    <p class="text-base leading-relaxed text-muted-foreground">
                        {{ __('app.landing.features.community.description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    {{ __('app.landing.books.title') }}
                </h2>
                <p class="text-lg text-muted-foreground">
                    {{ __('app.landing.books.subtitle') }}
                </p>
            </div>

            <!-- Placeholder for featured books -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 0; $i < 8; $i++)
                <div class="group hover:shadow-lg transition-all duration-200 border rounded-lg p-4">
                    <div class="flex space-x-3">
                        <div class="w-16 h-24 md:w-20 md:h-28 rounded-md overflow-hidden bg-muted flex-shrink-0">
                            <div class="w-full h-full bg-gradient-to-br from-muted to-muted/50"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-sm md:text-base line-clamp-2 mb-1">
                                Libro de ejemplo {{ $i + 1 }}
                            </h3>
                            <p class="text-sm text-muted-foreground mb-2">
                                Autor de ejemplo
                            </p>
                            <div class="flex items-center space-x-3 text-xs text-muted-foreground">
                                <span>2024</span>
                                <span>300 págs.</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('search') }}" class="inline-flex items-center px-6 py-3 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-lg font-medium transition-colors">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    {{ __('app.landing.books.explore_more') }}
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary text-primary-foreground">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    {{ __('app.landing.cta.title') }}
                </h2>
                <p class="text-xl mb-8 opacity-90">
                    {{ __('app.landing.cta.subtitle') }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-secondary text-secondary-foreground rounded-md text-lg font-medium hover:bg-secondary/90 transition-colors w-full sm:w-auto">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('app.landing.cta.create_account') }}
                    </a>
                    
                    <a href="{{ route('search') }}" class="inline-flex items-center justify-center px-6 py-3 border border-primary-foreground text-primary-foreground hover:bg-primary-foreground hover:text-primary rounded-md text-lg font-medium transition-colors w-full sm:w-auto">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('app.landing.cta.explore_without') }}
                    </a>
                </div>

                <p class="text-sm mt-6 opacity-75">
                    {{ __('app.landing.hero.no_credit') }}
                </p>
            </div>
        </div>
    </section>
</div>

<script>
    // Theme toggle functionality
    document.getElementById('theme-toggle').addEventListener('click', function() {
        const html = document.documentElement;
        const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.classList.remove('light', 'dark');
        html.classList.add(newTheme);
        document.cookie = `theme=${newTheme}; path=/; max-age=31536000`;
    });
</script>
@endsection
