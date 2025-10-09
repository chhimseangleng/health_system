<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Illuminate\Console\Command;

class AddRoleToExistingPatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:add-role
                          {--default=common disease : Default role value for existing patients}
                          {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add role field to existing patients in MongoDB collection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defaultRole = $this->option('default');
        $isDryRun = $this->option('dry-run');

        $this->info('Starting migration to add role field to existing patients...');

        // Validate default role value
        $validRoles = Patient::getRoles();
        if (!in_array($defaultRole, $validRoles)) {
            $this->error("Invalid default role: {$defaultRole}");
            $this->info('Valid roles are: ' . implode(', ', $validRoles));
            return 1;
        }

        // Find patients without role field (MongoDB compatible)
        $patientsWithoutRole = Patient::where(function($query) {
            $query->whereNull('role')
                  ->orWhere('role', '');
        })->get();

        $totalCount = $patientsWithoutRole->count();

        if ($totalCount === 0) {
            $this->info('No patients found without role field. Migration not needed.');
            return 0;
        }

        $this->info("Found {$totalCount} patients without role field.");

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
            $this->table(['Patient ID', 'Name', 'Current Role', 'New Role'],
                $patientsWithoutRole->map(function ($patient) use ($defaultRole) {
                    return [
                        $patient->patient_id ?? 'N/A',
                        $patient->first_name . ' ' . $patient->last_name,
                        $patient->role ?? 'NULL',
                        $defaultRole
                    ];
                })->toArray()
            );
            return 0;
        }

        // Confirm before proceeding
        if (!$this->confirm("Set role to '{$defaultRole}' for {$totalCount} patients?")) {
            $this->info('Migration cancelled.');
            return 0;
        }

        // Progress bar for the migration
        $progressBar = $this->output->createProgressBar($totalCount);
        $progressBar->start();

        $successCount = 0;
        $errorCount = 0;

        // Update patients in batches
        foreach ($patientsWithoutRole->chunk(100) as $patients) {
            foreach ($patients as $patient) {
                try {
                    $patient->role = $defaultRole;
                    $patient->save();
                    $successCount++;
                } catch (\Exception $e) {
                    $this->error("\nFailed to update patient {$patient->_id}: " . $e->getMessage());
                    $errorCount++;
                }
                $progressBar->advance();
            }
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        $this->info("Migration completed!");
        $this->info("✓ Successfully updated: {$successCount} patients");
        if ($errorCount > 0) {
            $this->warn("✗ Failed to update: {$errorCount} patients");
        }

        // Verify the migration
        $remainingWithoutRole = Patient::whereNull('role')->count();
        if ($remainingWithoutRole > 0) {
            $this->warn("Warning: {$remainingWithoutRole} patients still without role field.");
        } else {
            $this->info("✓ All patients now have a role assigned.");
        }

        return 0;
    }
}
