<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelTypeSeeder::class);
        $this->call(VariableDefinitionSeeder::class);
        $this->call(UserNotificationSeeder::class);

        $this->call(DocumentExtensionSeeder::class);
        $this->call(DocumentLoaderSeeder::class);
        $this->call(DocumentTypeSeeder::class);
    }
}
