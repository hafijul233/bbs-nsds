<?php

namespace Database\Seeders\Backend\Setting\User;

use App\Models\Backend\Setting\State;
use App\Models\Backend\Setting\User;
use Illuminate\Database\Seeder;

class OtherDirectorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        $states = State::where(['country_id' => 19])->get();

        foreach ($states as $state) {
            try {
                if ($state->type == 'district') {
                    $director = [
                        'name' => "{$state->name} District",
                        'state_id' => $state->id,
                        'username' => "DD_{$state->name}",
                        'email' => strtolower("deputy_director_{$state->name}@bbs.com"),
                        'remarks' => 'Deputy Director’s User ID',
                    ];
                    User::factory()->asDeputyDirector()->create($director);
                } elseif ($state->type == 'division') {
                    $director = [
                        'name' => "{$state->name} Division",
                        'state_id' => $state->id,
                        'username' => "JD_{$state->name}",
                        'email' => strtolower("joint_director_{$state->name}@bbs.com"),
                        'remarks' => 'Joint Director’s User ID',
                    ];
                    User::factory()->asJointDirector()->create($director);
                } else {
                    //nothing
                }
            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }
    }
}
