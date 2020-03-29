Заявка на регистрацию:
Фамилия: {{ $user->family }}
Имя: {{ $user->name }}
Отчество: {{ $user->patronymic }}
IP: {{ request()->ip() }}
Роль: {{ $user->roles()->first()->title }}
