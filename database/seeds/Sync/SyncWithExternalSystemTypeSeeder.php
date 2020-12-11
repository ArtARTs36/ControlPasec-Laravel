<?php

use App\Based\Models\SyncWithExternalSystemType;

class SyncWithExternalSystemTypeSeeder extends CommonSeeder
{
    public function run(): void
    {
        $this->fillModel(SyncWithExternalSystemType::class, 'data_sync_with_external_system_types');
    }
}
