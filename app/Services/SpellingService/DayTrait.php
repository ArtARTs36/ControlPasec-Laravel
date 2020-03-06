<?php

namespace App\Services\SpellingService;

trait DayTrait
{
    private static $dayOfWeek = [
        '',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
        'Воскресение'
    ];

    /**
     * Получить массив всех дней неделей
     * @return array
     */
    public static function getAllDaysOfWeeks(): array
    {
        return self::$dayOfWeek;
    }

    /**
     * Получить день недели из даты/номера дня недели
     * @param \DateTime|int $identity
     * @return string
     */
    public static function getDayOfWeek($identity): string
    {
        if ($identity instanceof \DateTime) {
            $identity = $identity->format('N');
        }

        return self::$dayOfWeek[$identity];
    }

    /**
     * Получить текущий день недели
     * @return string
     * @throws \Exception
     */
    public static function getCurrentDayOfWeek(): string
    {
        return self::$dayOfWeek[(new \DateTime())->format('N')];
    }
}
