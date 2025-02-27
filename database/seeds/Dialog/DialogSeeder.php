<?php

use App\User;
use Illuminate\Database\Eloquent\Collection;

class DialogSeeder extends CommonSeeder
{
    /** @var Collection */
    private $users;

    public function run(): void
    {
        $this->users = User::all();

        if (env('APP_ENV') === 'local') {
            $this->randomData(100);
        }
    }

    private function randomData(int $count)
    {
        for ($i = 0; $i < $count; $i++) {

        }
    }
}
