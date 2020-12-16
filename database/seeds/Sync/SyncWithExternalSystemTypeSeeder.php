<?php

use App\Based\Models\ExternalSystem;

class SyncWithExternalSystemTypeSeeder extends CommonSeeder
{
    public function run(): void
    {
        $this->fillModel(ExternalSystem::class, 'data_sync_with_external_system_types');
    }
}
