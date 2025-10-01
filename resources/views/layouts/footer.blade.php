<footer class="border-t bg-muted/30">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-xl font-bold text-primary">{{ __('app.name') }}</span>
                </div>
                <p class="text-sm text-muted-foreground">
                    {{ __('app.tagline') }}
                </p>
            </div>

            <!-- Navigation -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold">{{ __('navigation.title') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-muted-foreground hover:text-primary transition-colors">{{ __('navigation.home') }}</a></li>
                    <li><a href="{{ route('search') }}" class="text-muted-foreground hover:text-primary transition-colors">{{ __('navigation.search') }}</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="text-muted-foreground hover:text-primary transition-colors">{{ __('navigation.dashboard') }}</a></li>
                        <li><a href="{{ route('library') }}" class="text-muted-foreground hover:text-primary transition-colors">{{ __('navigation.library') }}</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Features -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold">{{ __('landing.features.title') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li class="text-muted-foreground">{{ __('landing.features.organize.title') }}</li>
                    <li class="text-muted-foreground">{{ __('landing.features.search.title') }}</li>
                    <li class="text-muted-foreground">{{ __('landing.features.notes.title') }}</li>
                    <li class="text-muted-foreground">{{ __('landing.features.import.title') }}</li>
                </ul>
            </div>

            <!-- Support -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold">{{ __('footer.support') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-muted-foreground hover:text-primary transition-colors">{{ __('footer.help') }}</a></li>
                    <li><a href="#" class="text-muted-foreground hover:text-primary transition-colors">{{ __('footer.contact') }}</a></li>
                    <li><a href="#" class="text-muted-foreground hover:text-primary transition-colors">{{ __('footer.privacy') }}</a></li>
                    <li><a href="#" class="text-muted-foreground hover:text-primary transition-colors">{{ __('footer.terms') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-muted-foreground">
                © {{ date('Y') }} {{ __('app.name') }}. {{ __('footer.rights') }}
            </p>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <span class="text-sm text-muted-foreground">{{ __('footer.made_with') }}</span>
                <span class="text-red-500">♥</span>
                <span class="text-sm text-muted-foreground">{{ __('footer.in_spain') }}</span>
            </div>
        </div>
    </div>
</footer>
