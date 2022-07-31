<?php


return [
    'columns' => [
        'createdByAttribute' => 'created_by',
        'updatedByAttribute' => 'updated_by',
        'deletedByAttribute' => 'deleted_by',
    ],
    'models' => [
        'user' => \App\Models\Backend\Setting\User::class
    ],
    'foreign_id' => 'id'
];