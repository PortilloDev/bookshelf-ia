<header class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-xl font-bold text-primary">{{ __('app.name') }}</span>
                </a>
                
                <!-- Public Navigation -->
                @guest
                    <nav class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('home') }}" 
                           class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : 'text-muted-foreground' }}">
                            {{ __('app.navigation.home') }}
                        </a>
                        <a href="{{ route('search') }}" 
                           class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('search') ? 'text-primary' : 'text-muted-foreground' }}">
                            {{ __('app.navigation.search') }}
                        </a>
                    </nav>
                @endguest

                <!-- Private Navigation -->
                @auth
                    <nav class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" 
                           class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-muted-foreground' }}">
                            {{ __('app.navigation.dashboard') }}
                        </a>
                        <a href="{{ route('library') }}" 
                           class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('library') ? 'text-primary' : 'text-muted-foreground' }}">
                            {{ __('app.navigation.library') }}
                        </a>
                        <a href="{{ route('search') }}" 
                           class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('search') ? 'text-primary' : 'text-muted-foreground' }}">
                            {{ __('app.navigation.search') }}
                        </a>
                    </nav>
                @endauth
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Language Selector -->
                <div class="relative">
                    <select id="language-selector" class="bg-transparent border-none text-sm focus:outline-none">
                        <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>ES</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    </select>
                </div>
                
                <!-- Theme Toggle -->
                <button id="theme-toggle" class="p-2 rounded-md hover:bg-accent">
                    <svg id="sun-icon" class="h-4 w-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg id="moon-icon" class="h-4 w-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <!-- Reading Stats for authenticated users -->
                @auth
                    @php
                        $stats = auth()->user()->reading_stats;
                    @endphp
                    @if($stats)
                        <div class="hidden lg:flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-secondary text-secondary-foreground">
                                {{ $stats['readBooks'] }} {{ __('app.books.categories.read') }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border border-input bg-background text-foreground">
                                {{ $stats['readingBooks'] }} {{ __('app.books.categories.reading') }}
                            </span>
                        </div>
                    @endif
                @endauth

                <!-- Authentication Actions -->
                @guest
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-foreground hover:text-primary transition-colors">
                            {{ __('app.navigation.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors">
                            {{ __('app.navigation.register') }}
                        </a>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <!-- Quick Add Book Button -->
                        <a href="{{ route('search') }}" class="hidden md:flex items-center px-3 py-2 text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('books.actions.addToLibrary') }}
                        </a>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative h-8 w-8 rounded-full bg-muted hover:bg-accent transition-colors">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="h-8 w-8 rounded-full">
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-popover border border-border rounded-md shadow-lg z-50"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                <div class="p-2">
                                    <div class="flex flex-col space-y-1">
                                        <p class="font-medium text-sm">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="border-t border-border"></div>
                                <div class="py-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm hover:bg-accent">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ __('app.navigation.dashboard') }}
                                    </a>
                                    <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-sm hover:bg-accent">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ __('app.navigation.profile') }}
                                    </a>
                                    <a href="{{ route('settings') }}" class="flex items-center px-4 py-2 text-sm hover:bg-accent">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ __('app.navigation.settings') }}
                                    </a>
                                </div>
                                <div class="border-t border-border"></div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm hover:bg-accent">
                                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            {{ __('app.navigation.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Mobile Navigation -->
        @if(request()->routeIs('home') || request()->routeIs('search') || auth()->check())
            <div class="md:hidden border-t py-2">
                <nav class="flex items-center justify-center space-x-4">
                    @guest
                        <a href="{{ route('home') }}" class="text-sm font-medium text-muted-foreground hover:text-primary">
                            {{ __('app.navigation.home') }}
                        </a>
                        <a href="{{ route('search') }}" class="text-sm font-medium text-muted-foreground hover:text-primary">
                            {{ __('app.navigation.search') }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-muted-foreground hover:text-primary">
                            {{ __('app.navigation.dashboard') }}
                        </a>
                        <a href="{{ route('library') }}" class="text-sm font-medium text-muted-foreground hover:text-primary">
                            {{ __('app.navigation.library') }}
                        </a>
                        <a href="{{ route('search') }}" class="text-sm font-medium text-muted-foreground hover:text-primary">
                            {{ __('app.navigation.search') }}
                        </a>
                    @endguest
                </nav>
            </div>
        @endif
    </div>
</header>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
