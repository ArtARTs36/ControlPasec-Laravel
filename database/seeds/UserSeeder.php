<?php

use App\User;
use Illuminate\Support\Str;

/**
 * Class UserSeeder
 * Наполнитель для таблицы пользователей
 */
class UserSeeder extends CommonSeeder
{
    public function run()
    {
        if (env('ENV_TYPE') != 'dev') {
            return null;
        }

        factory(User::class, 100)->create();
        $this->createAdmin();
    }

    private function createAdmin(): void
    {
        $user = new User();
        $user->name = 'admin';
        $user->patronymic = 'admin';
        $user->family = 'admin';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->email = 'admin@admin.ru';
        $user->position = 'Администратор';
        $user->remember_token = Str::random(10);
        $user->is_active = true;
        $user->save();
    }
}
