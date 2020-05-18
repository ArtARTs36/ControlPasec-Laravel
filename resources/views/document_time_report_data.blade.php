@php

    use App\Models\ControlTime\TimeReport;
    use Carbon\Carbon;use Dba\ControlTime\Services\TimeService;

    $timeReport = TimeReport::query()
        ->with(TimeReport::RELATION_EMPLOYEE)
        ->where(TimeReport::FIELD_DOCUMENT_ID, $document->id)
        ->first();

    $times = TimeService::getByPeriod(
        $timeReport->employee,
        Carbon::parse($timeReport->start_date),
        Carbon::parse($timeReport->end_date)
    );

    $hours = 0;

    $timesData = [];
    foreach ($times as $key => $time) {
        $timesData[] = [
            'СПИСАНИЕ_ДАТА' => $time->date,
            'СПИСАНИЕ_ЧАСЫ' => $time->getHours(),
            'СПИСАНИЕ_КОММЕНТ' => $time->comment,
        ];

        $hours += $time->getHours();
    }

    //

    $timeReport->times_quantity = $hours;
    $timeReport->save();

    //

    $data['variables'] = [
        'ЧАСЫ_КОЛВО' => $hours,
        'СОТРУДНИК_ПРЕДСТАВЛЕНИЕ' => $timeReport->employee->getFullName(),
        'ПЕРИОД_НАЧАЛО' => $timeReport->start_date,
        'ПЕРИОД_КОНЕЦ' => $timeReport->end_date,
    ];

    $data['tables'] = [
         $timesData
    ];

@endphp

{!! json_encode($data) !!}
