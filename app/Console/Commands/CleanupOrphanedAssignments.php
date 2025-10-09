<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PatientAssign;

class CleanupOrphanedAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignments:cleanup-orphaned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned patient assignments (assignments without valid patients)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of orphaned assignments...');

        try {
            $count = PatientAssign::cleanupOrphanedAssignments();

            if ($count > 0) {
                $this->warn("Cleaned up {$count} orphaned assignments.");
            } else {
                $this->info('No orphaned assignments found.');
            }

            $this->info('Cleanup completed successfully.');

        } catch (\Exception $e) {
            $this->error('Error during cleanup: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

