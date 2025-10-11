<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;

class ResetFailedBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:reset-failed {--dry-run : Show what would be reset without actually resetting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset books marked as import_failed back to import status for retry';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Looking for books marked as import_failed...');
        
        $failedBooks = Book::where('source', 'import_failed')->get();
        
        if ($failedBooks->isEmpty()) {
            $this->info('No books marked as import_failed found.');
            return;
        }
        
        $this->info("Found {$failedBooks->count()} books marked as import_failed.");
        
        if ($dryRun) {
            $this->info('Books that would be reset:');
            foreach ($failedBooks as $book) {
                $this->line("  - {$book->title} (ID: {$book->id})");
            }
            $this->info('Run without --dry-run to actually reset these books.');
        } else {
            $reset = 0;
            foreach ($failedBooks as $book) {
                $book->update(['source' => 'import']);
                $reset++;
                $this->line("Reset: {$book->title}");
            }
            $this->info("Reset {$reset} books back to 'import' status.");
            $this->info('You can now run the enrichment command again to retry these books.');
        }
    }
}
