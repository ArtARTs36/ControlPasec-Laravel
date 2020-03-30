<?php

namespace App\Support;

use App\User;

class Avatar
{
    protected static $randomDir = '/random-avatars/';

    protected static $females = null;

    protected static $males = null;

    public static function byUser(User $user)
    {
        return self::byGender($user->gender);
    }

    public static function byGender(?int $gender): string
    {
        return self::getAvatar(
            $gender === User::GENDER_MALE ? 'males' : 'females',
            $gender === User::GENDER_MALE ?
            env('RANDOM_AVATARS_MALES_FOLDER', 'males') :
            env('RANDOM_AVATARS_FEMALES_FOLDER', 'females')
        );
    }

    protected static function getAvatar(string $array, string $folder): string
    {
        if (self::$$array === null) {
            $path = public_path(self::$randomDir . $folder);
            $files = array_values(array_diff(scandir($path), ['.', '..']));

            self::$$array = array_map(function (string $file) use ($folder) {
                return self::$randomDir . $folder . DIRECTORY_SEPARATOR . $file;
            }, $files);
        }

        $rand = rand(0, count(self::$$array) - 1);

        return self::$$array[$rand];
    }
}
