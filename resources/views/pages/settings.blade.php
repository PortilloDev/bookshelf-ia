@extends('layouts.app')

@section('title', __('app.auth.settings.title') . ' - ' . __('app.name'))

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-foreground">
                {{ __('app.auth.settings.title') }}
            </h1>
            <p class="mt-2 text-muted-foreground">
                {{ __('app.auth.settings.subtitle') }}
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Settings -->
            <div class="lg:col-span-2">
                <div class="bg-background shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-xl font-semibold text-foreground mb-6">
                            {{ __('app.auth.settings.profile.title') }}
                        </h2>

                        <form method="POST" action="{{ route('settings.profile') }}" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-foreground mb-1">
                                        {{ __('app.auth.register.name') }}
                                    </label>
                                    <input id="name" 
                                           name="name" 
                                           type="text" 
                                           required 
                                           value="{{ old('name', $user->name) }}"
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
                                           required 
                                           value="{{ old('email', $user->email) }}"
                                           class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('email') border-destructive @enderror"
                                           placeholder="{{ __('app.auth.register.email_placeholder') }}">
                                    @error('email')
                                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    {{ __('app.common.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Password Settings -->
                <div class="bg-background shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-foreground mb-4">
                            {{ __('app.auth.settings.password.title') }}
                        </h3>

                        <form method="POST" action="{{ route('settings.password') }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-foreground mb-1">
                                    {{ __('app.auth.settings.password.current') }}
                                </label>
                                <input id="current_password" 
                                       name="current_password" 
                                       type="password" 
                                       required 
                                       class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('current_password') border-destructive @enderror"
                                       placeholder="{{ __('app.auth.settings.password.current_placeholder') }}">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-foreground mb-1">
                                    {{ __('app.auth.settings.password.new') }}
                                </label>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       required 
                                       class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('password') border-destructive @enderror"
                                       placeholder="{{ __('app.auth.settings.password.new_placeholder') }}">
                                @error('password')
                                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-foreground mb-1">
                                    {{ __('app.auth.settings.password.confirm') }}
                                </label>
                                <input id="password_confirmation" 
                                       name="password_confirmation" 
                                       type="password" 
                                       required 
                                       class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground placeholder-muted-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent"
                                       placeholder="{{ __('app.auth.settings.password.confirm_placeholder') }}">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    {{ __('app.auth.settings.password.update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="bg-background shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-foreground mb-4">
                            {{ __('app.auth.settings.preferences.title') }}
                        </h3>

                        <form method="POST" action="{{ route('settings.preferences') }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="language" class="block text-sm font-medium text-foreground mb-1">
                                    {{ __('app.auth.settings.preferences.language') }}
                                </label>
                                <select id="language" 
                                        name="language" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent">
                                    <option value="es" {{ (session('language', 'es') == 'es') ? 'selected' : '' }}>Español</option>
                                    <option value="en" {{ (session('language', 'es') == 'en') ? 'selected' : '' }}>English</option>
                                </select>
                            </div>

                            <div>
                                <label for="theme" class="block text-sm font-medium text-foreground mb-1">
                                    {{ __('app.auth.settings.preferences.theme') }}
                                </label>
                                <select id="theme" 
                                        name="theme" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-input bg-background text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent">
                                    <option value="light" {{ (session('theme', 'light') == 'light') ? 'selected' : '' }}>Claro</option>
                                    <option value="dark" {{ (session('theme', 'light') == 'dark') ? 'selected' : '' }}>Oscuro</option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    {{ __('app.common.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
