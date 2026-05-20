<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SetupCmsPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:setup-permissions 
                            {--assign-to-admins : Assign permissions to admin users}
                            {--user= : Assign permissions to specific user email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up permissions for CMS functionality';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔐 Setting up CMS Permissions');
        $this->newLine();

        $permissions = [
            'Create Section Template',
            'Read Section Template', 
            'Update Section Template',
            'Delete Section Template',
            'Create Media',
            'Read Media',
            'Update Media', 
            'Delete Media',
            'manage cms'
        ];

        $this->info('Creating permissions...');
        $created = 0;
        $existing = 0;

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            
            if ($permission->wasRecentlyCreated) {
                $this->line("✅ Created: {$permissionName}");
                $created++;
            } else {
                $this->line("ℹ️  Exists: {$permissionName}");
                $existing++;
            }
        }

        $this->newLine();
        $this->info("📊 Permission Summary:");
        $this->line("✅ Created: {$created} permissions");
        $this->line("ℹ️  Existing: {$existing} permissions");

        // Assign permissions to users
        if ($this->option('assign-to-admins')) {
            $this->assignToAdmins($permissions);
        }

        if ($userEmail = $this->option('user')) {
            $this->assignToUser($userEmail, $permissions);
        }

        if (!$this->option('assign-to-admins') && !$this->option('user')) {
            $this->newLine();
            $this->info('🔧 Next Steps:');
            $this->line('1. Assign permissions to admin users:');
            $this->line('   php artisan cms:setup-permissions --assign-to-admins');
            $this->newLine();
            $this->line('2. Or assign to specific user:');
            $this->line('   php artisan cms:setup-permissions --user=admin@example.com');
        }

        $this->newLine();
        $this->line('🎉 CMS permissions setup complete!');

        return 0;
    }

    /**
     * Assign permissions to admin users
     */
    protected function assignToAdmins($permissions)
    {
        $this->newLine();
        $this->info('👥 Assigning permissions to admin users...');

        // Try to find admin users by role or email
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'like', '%admin%');
        })->orWhere('email', 'like', '%admin%')->get();

        if ($adminUsers->isEmpty()) {
            $this->warn('No admin users found. Please specify a user manually.');
            return;
        }

        foreach ($adminUsers as $user) {
            try {
                $user->givePermissionTo($permissions);
                $this->line("✅ Assigned permissions to: {$user->email}");
            } catch (\Exception $e) {
                $this->error("❌ Failed to assign permissions to {$user->email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Assign permissions to specific user
     */
    protected function assignToUser($email, $permissions)
    {
        $this->newLine();
        $this->info("👤 Assigning permissions to: {$email}");

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User not found: {$email}");
            return;
        }

        try {
            $user->givePermissionTo($permissions);
            $this->line("✅ Successfully assigned CMS permissions to: {$email}");
        } catch (\Exception $e) {
            $this->error("❌ Failed to assign permissions: " . $e->getMessage());
        }
    }
}
