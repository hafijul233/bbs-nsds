<?php

namespace Database\Seeders\Backend\Setting\User;

use App\Models\Backend\Setting\User;
use Illuminate\Database\Seeder;

class DirectorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $directors = [
            [
                'name' => 'Agriculture Wing',
                'username' => 'Director_Agriculture',
                'email' => strtolower('Director_Agriculture@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'Census Wing',
                'username' => 'Director_Census',
                'email' => strtolower('Director_Census@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'Computer Wing',
                'username' => 'Director_Computer',
                'email' => strtolower('Director_Computer@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'Demography and Health Wing',
                'username' => 'Director_Demography',
                'email' => strtolower('Director_Demography@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'FA and MIS Wing',
                'username' => 'Director_MIS',
                'email' => strtolower('Director_MIS@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'Industry and Labor Wing',
                'username' => 'Director_Industry',
                'email' => strtolower('Director_Industry@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'National Accounting Wing',
                'username' => 'Director_National',
                'email' => strtolower('Director_National@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
            [
                'name' => 'SSTI',
                'username' => 'Director_SSTI',
                'email' => strtolower('Director_SSTI@bbs.com'),
                'remarks' => 'Director’s User ID'
            ],
        ];

        foreach ($directors as $director) {
            try {
                User::factory()->make($director);

            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }
    }
}
