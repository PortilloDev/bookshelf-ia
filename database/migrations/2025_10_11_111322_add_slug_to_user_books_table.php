<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\UserBook;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });

        // Generate slugs for existing user_books
        UserBook::with(['user', 'book'])->chunk(100, function ($userBooks) {
            foreach ($userBooks as $userBook) {
                $userBook->slug = $this->generateUniqueSlug($userBook);
                $userBook->save();
            }
        });

        // Make slug unique and not null after populating
        Schema::table('user_books', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    /**
     * Generate a unique slug for a user book
     */
    private function generateUniqueSlug(UserBook $userBook): string
    {
        $baseSlug = Str::slug($userBook->user->name . '-' . $userBook->book->title);
        $slug = $baseSlug;
        $counter = 1;

        while (UserBook::where('slug', $slug)->where('id', '!=', $userBook->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
};