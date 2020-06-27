<?php

use App\Services\Document\TemplateService;

//

$permissions = \App\Models\User\Permission::all();
$roles = \App\Models\User\Role::all();

$data[TemplateService::VARIABLES_FIELD] = [
    'АКТУАЛЬНОСТЬ_ДАТА' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    'ПОЛНОМОЧИЯ_КОЛИЧЕСТВО' => $permissions->count(),
    "РОЛИ_КОЛИЧЕСТВО" => $roles->count(),
    "ПОЛЬЗОВАТЕЛИ_КОЛИЧЕСТВО" => \App\User::count(),
];

//

$permissionsData = [];
foreach ($permissions as $permission) {
    $permissionsData[] = [
        'ПОЛНОМОЧИЕ_НАЗВАНИЕ' => $permission->name,
        'ПОЛНОМОЧИЕ_ОПИСАНИЕ' => $permission->title,
    ];
}

$permissionsWidthData = [];

$line = 0;
$number = 1;
foreach ($permissions->chunk(2) as $permissionLine) {
    $number = 1;
    $permissionsWidthData[$line] = [];

    foreach ($permissionLine as $permission) {
        $currentNumber = $number++;
        $permissionsWidthData[$line] += [
            "Ш_{$currentNumber}_ПОЛНОМОЧИЕ_НАЗВАНИЕ" => prepare($permission->name),
            "Ш_{$currentNumber}_ПОЛНОМОЧИЕ_ОПИСАНИЕ" => $permission->title,
        ];
    }

    $line++;
}

if ($permissions->count() % 2 !== 0) {
    $permissionsWidthData[$line - 1] += [
        "Ш_2_ПОЛНОМОЧИЕ_НАЗВАНИЕ" => '',
        "Ш_2_ПОЛНОМОЧИЕ_ОПИСАНИЕ" => '',
    ];
}

//

$rolesData = [];
foreach ($roles as $role) {
    $rolesData[] = [
        "РОЛЬ_НАЗВАНИЕ" => $role->name,
        "РОЛЬ_ОПИСАНИЕ" => $role->title,
    ];
}

//

$data[TemplateService::TABLES_FIELD] = [
    $permissionsData,
    $permissionsWidthData,
    $rolesData,
];

function prepare($text)
{
    $length = mb_strlen($text);

    if ($length > 15) {
        $text = str_replace("_", " _", $text);
    }

    return $text;
}

return $data;
