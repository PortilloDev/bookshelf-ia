<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-welcome {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the welcome email functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Enter email address to test');

        if (!$email) {
            $this->error('Email address is required');
            return 1;
        }

        // Verificar si el email es válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address');
            return 1;
        }

        $this->info("Testing welcome email for: {$email}");

        try {
            // Buscar si existe un usuario con ese email, o crear uno temporal
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                if ($this->confirm('User not found. Create a temporary user for testing?', true)) {
                    $user = User::create([
                        'name' => 'Test User',
                        'email' => $email,
                        'password' => bcrypt('temporary-password'),
                    ]);
                    $this->info('✅ Temporary user created');
                } else {
                    $this->error('Cannot test without a valid user');
                    return 1;
                }
            } else {
                $this->info("✅ Using existing user: {$user->name}");
            }

            // Opción 1: Envío directo (síncrono)
            if ($this->confirm('Send email synchronously (direct)?', true)) {
                Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
                $this->info('✅ Email sent successfully (synchronous)');
            }

            // Opción 2: Envío asíncrono (Job)
            if ($this->confirm('Send email asynchronously (Job)?', true)) {
                SendWelcomeEmail::dispatch($user);
                $this->info('✅ Email job dispatched successfully (asynchronous)');
                $this->warn('Note: Make sure queue workers are running to process the job');
            }

            // Limpiar usuario temporal si se creó
            if ($user->name === 'Test User' && $this->confirm('Delete temporary user?', true)) {
                $user->delete();
                $this->info('✅ Temporary user deleted');
            }

            $this->info('Test completed successfully!');
            return 0;

        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
