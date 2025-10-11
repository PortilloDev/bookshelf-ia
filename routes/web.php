<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\LegalController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/add', [LibraryController::class, 'addBook'])->name('library.add');
    Route::put('/library/{userBookSlug}/update', [LibraryController::class, 'updateBook'])->name('library.update');
    Route::delete('/library/{userBookSlug}', [LibraryController::class, 'deleteBook'])->name('library.delete');
    
    // Custom categories
    Route::get('/categories', [LibraryController::class, 'manageCategories'])->name('categories.manage');
    Route::post('/categories', [LibraryController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{categoryId}', [LibraryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{categoryId}', [LibraryController::class, 'deleteCategory'])->name('categories.delete');
    Route::post('/library/{userBookSlug}/categories', [LibraryController::class, 'assignCategories'])->name('library.categories.assign');
    
    Route::get('/import', [ImportController::class, 'index'])->name('import');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Template routes (public)
Route::get('/template/download', [TemplateController::class, 'downloadTemplate'])->name('template.download');
Route::post('/template/upload', [TemplateController::class, 'uploadTemplate'])->name('template.upload');

// Book details route (public)
Route::get('/book/{source}/{id}', [SearchController::class, 'show'])->name('book.details');

// Language switching
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['es', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');


Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback'])->name('google.callback');

// Legal pages (public)
Route::get('/legal', [LegalController::class, 'legal'])->name('legal');
Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies');
