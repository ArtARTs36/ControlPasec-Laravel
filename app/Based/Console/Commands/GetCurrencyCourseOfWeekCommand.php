<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetCurrencyCourseOfWeekCommand extends Command
{
    protected $signature = 'get-currency-course:week';

    protected $description = 'Command description';

    protected $finder;

    protected $service;

    public function __construct(Finder $finder, CurrencyService $service)
    {
        parent::__construct();

        $this->finder = $finder;
        $this->service = $service;
    }

    public function handle()
    {
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::parse("-{$i} days");

            try {
                $this->service->createOfExternals($this->finder->getOnDate($date));
            } catch (\Throwable $exception) {
                $this->warn($exception->getMessage());
            }
        }
    }
}
