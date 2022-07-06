<?php

namespace Database\Seeders\Backend\User;

use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use App\Supports\BanglaConverter;
use App\Supports\Constant;
use App\Supports\Utility;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BBSUserSeeder extends Seeder
{
    private UserRepository $userRepository;

    /**
     * BBSUserSeeder constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('bn_BD');

        //Director’s User ID
        $this->userRepository->create(
            array(
                'name' => 'Agriculture Wing',
                'username' => 'Director_Agriculture',
                'email' => strtolower('Director_Agriculture@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'Census Wing',
                'username' => 'Director_Census',
                'email' => strtolower('Director_Census@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'Computer Wing',
                'username' => 'Director_Computer',
                'email' => strtolower('Director_Computer@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'Demography and Health Wing',
                'username' => 'Director_Demography',
                'email' => strtolower('Director_Demography@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'FA and MIS Wing',
                'username' => 'Director_MIS',
                'email' => strtolower('Director_MIS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'Industry and Labor Wing',
                'username' => 'Director_Industry',
                'email' => strtolower('Director_Industry@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'National Accounting Wing',
                'username' => 'Director_National',
                'email' => strtolower('Director_National@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
        $this->userRepository->create(
            array(
                'name' => 'SSTI',
                'username' => 'Director_SSTI',
                'email' => strtolower('Director_SSTI@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            )
        );
    }

}
