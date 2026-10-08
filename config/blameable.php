<?php

use App\Models\Backend\Setting\User;

return [
    'columns' => [
        'createdByAttribute' => 'created_by',
        'updatedByAttribute' => 'updated_by',
        'deletedByAttribute' => 'deleted_by',
    ],
    'models' => [
        'user' => User::class,
    ],
    'foreign_id' => 'id',
];
