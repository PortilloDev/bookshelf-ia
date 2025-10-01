@extends('layouts.app')

@section('title', __('app.auth.register.title') . ' - ' . __('app.name'))

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-primary/10">
                <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-foreground">
                {{ __('app.auth.register.title') }}
            </h2>
            <p class="mt-2 text-center text-sm text-muted-foreground">
                {{ __('app.auth.register.subtitle') }}
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-foreground mb-1">
                        {{ __('app.auth.register.name') }}
                    </label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           autocomplete="name" 
                           required 
                           value="{{ old('name') }}"
                           class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('name') border-destructive @enderror"
                           placeholder="{{ __('app.auth.register.name_placeholder') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-foreground mb-1">
                        {{ __('app.auth.register.email') }}
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('email') border-destructive @enderror"
                           placeholder="{{ __('app.auth.register.email_placeholder') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-foreground mb-1">
                        {{ __('app.auth.register.password') }}
                    </label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           autocomplete="new-password" 
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('password') border-destructive @enderror"
                           placeholder="{{ __('app.auth.register.password_placeholder') }}">
                    @error('password')
                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-foreground mb-1">
                        {{ __('app.auth.register.confirm_password') }}
                    </label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           autocomplete="new-password" 
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent"
                           placeholder="{{ __('app.auth.register.confirm_password_placeholder') }}">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" 
                       name="terms" 
                       type="checkbox" 
                       required
                       class="h-4 w-4 text-primary focus:ring-ring border-input rounded">
                <label for="terms" class="ml-2 block text-sm text-foreground">
                    {{ __('app.auth.register.accept_terms') }}
                    <a href="#" class="font-medium text-primary hover:text-primary/80">{{ __('app.auth.register.terms') }}</a>
                    {{ __('common.and') }}
                    <a href="#" class="font-medium text-primary hover:text-primary/80">{{ __('app.auth.register.privacy') }}</a>
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    {{ __('app.auth.register.title') }}
                </button>
            </div>

            <!-- Google OAuth Button -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-input"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-background text-muted-foreground">{{ __('app.auth.register.continue_with_email') }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('google.redirect') }}" 
                       class="w-full inline-flex justify-center py-2 px-4 border border-input rounded-md shadow-sm bg-background text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        {{ __('app.auth.register.continue_with_google') }}
                    </a>
                </div>
            </div>

            <div class="text-center">
                <p class="text-sm text-muted-foreground">
                    {{ __('app.auth.register.has_account') }}
                    <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80">
                        {{ __('app.auth.register.login_here') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
