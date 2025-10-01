@extends('layouts.app')

@section('title', __('app.auth.profile.title') . ' - ' . __('app.name'))

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-background shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h1 class="text-2xl font-bold text-foreground mb-6">
                    {{ __('app.auth.profile.title') }}
                </h1>

                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
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

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-muted-foreground">
                            {{ __('app.auth.profile.member_since') }}: {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 border border-input rounded-md shadow-sm text-sm font-medium text-foreground bg-background hover:bg-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            {{ __('app.common.cancel') }}
                        </a>
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
@endsection
