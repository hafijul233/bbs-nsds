<?php

namespace Database\Seeders\Backend\Setting;

use App\Models\Backend\Setting\Role;
use App\Supports\Constant;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => Constant::SUPER_ADMIN_ROLE,
            'remarks' => 'Role which will have all privileges.'
        ]);

        $roles = [
            [
                'name' => 'Administrator',
                'remarks' => 'Role which will have all privileges with out restore deleted data.'
            ]
            , [
                'name' => 'Director',
                'remarks' => 'Role which will have basic privileges and report generation.'
            ]
            , [
                'name' => 'Joint Director',
                'remarks' => 'Role which will have basic privileges and report generation.'
            ]
            , [
                'name' => 'Deputy Director',
                'remarks' => 'Role which will have basic privileges and report generation.'
            ]
            , [
                'name' => 'Project Director',
                'remarks' => 'Role which will have basic privileges and report generation.'
            ]

            , [
                'name' => 'Focal Point Officer',
                'remarks' => 'Role which will have basic privileges and report generation.'
            ]

            , [
                'name' => 'Enumerator',
                'remarks' => 'Role which will have basic operation and minimal system options.'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
