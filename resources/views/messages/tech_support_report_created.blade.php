Поступило обращение в техническую поддержку:
Номер: {{ $report->id }}
@if ($report->isWroteByGuest())
Автор: {{ $report->author_title }}
Контакты: {{ $report->author_contact }}
@else
Пользователь: {{ $report->user->getFullName() }}
@endif
Обращение: {{ $report->message }}
IP: {{ $report->ip }}
