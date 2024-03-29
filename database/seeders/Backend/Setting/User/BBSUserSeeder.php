<?php

namespace Database\Seeders\Backend\Setting\User;

use App\Models\Backend\Setting\Role;
use App\Models\Backend\Setting\User;
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
     *
     * @param  UserRepository  $userRepository
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

        //Project Information User ID
        $PD_LFS = $this->userRepository->create(
            [
                'name' => 'শ্রমশক্তি জরিপের মাধ্যমে শ্রমবাজার তথ্যের উন্নয়ন প্রকল্প',
                'username' => 'PD_LFS',
                'email' => strtolower('PD_LFS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_LFS, 'Project Director')) {
            throw new \RuntimeException('PD_LFS User Role Assignment Failed');
        }
        $PD_FSS = $this->userRepository->create(
            [
                'name' => 'খাদ্য নিরাপত্তা পরিসংখ্যান প্রকল্প ২০22',
                'username' => 'PD_FSS',
                'email' => strtolower('PD_FSS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_FSS, 'Project Director')) {
            throw new \RuntimeException('PD_FSS User Role Assignment Failed');
        }
        $PD_LAS = $this->userRepository->create(
            [
                'name' => 'টেকসই উন্নয়ন অভীষ্ট পরিবীক্ষণে প্রায়োগিক সাক্ষরতা নিরূপণ জরিপ (এলএএস)’ প্রকল্প',
                'username' => 'PD_LAS',
                'email' => strtolower('PD_LAS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_LAS, 'Project Director')) {
            throw new \RuntimeException('PD_LAS User Role Assignment Failed');
        }
        $PD_IGCRI = $this->userRepository->create(
            [
                'name' => 'ইমপ্রুভমেন্ট অব জিডিপি কম্পাইলেশন এন্ড রিবেসিং অব ইনডিসেস প্রজেক্ট (QIIP+ PPI)',
                'username' => 'PD_IGCRI',
                'email' => strtolower('PD_IGCRI@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_IGCRI, 'Project Director')) {
            throw new \RuntimeException('PD_IGCRI User Role Assignment Failed');
        }
        $PD_ECDS = $this->userRepository->create(
            [
                'name' => 'পরিবেশ জলবায়ূ পরিবর্তন ও দুর্যোগ পরিসংখ্যান শক্তিশালীকরণ (ইসিডিএস) প্রকল্প',
                'username' => 'PD_ECDS',
                'email' => strtolower('PD_ECDS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_ECDS, 'Project Director')) {
            throw new \RuntimeException('PD_ECDS User Role Assignment Failed');
        }
        $PD_NSPD = $this->userRepository->create(
            [
                'name' => 'জাতীয় প্রতিবন্ধী ব্যক্তি জরিপ ২০১৯ (১ম সংশোধিত)',
                'username' => 'PD_NSPD',
                'email' => strtolower('PD_NSPD@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_NSPD, 'Project Director')) {
            throw new \RuntimeException('PD_NSPD User Role Assignment Failed');
        }
        $PD_HIES = $this->userRepository->create(
            [
                'name' => 'খানার আয় ও ব্যয় জরিপ ২০২০-২১ প্রকল্প',
                'username' => 'PD_HIES',
                'email' => strtolower('PD_HIES@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_HIES, 'Project Director')) {
            throw new \RuntimeException('PD_HIES User Role Assignment Failed');
        }
        $PD_SCBBS = $this->userRepository->create(
            [
                'name' => 'Strengthening Capacity of BBS for Integrating Statistical data with Geocode and Geographical Information System Project',
                'username' => 'PD_SCBBS',
                'email' => strtolower('PD_SCBBS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_SCBBS, 'Project Director')) {
            throw new \RuntimeException('PD_SCBBS User Role Assignment Failed');
        }
        $PD_NSDS = $this->userRepository->create(
            [
                'name' => 'ন্যাশনাল স্ট্রেটেজি ফর দি ডেভেলপমেন্ট অব স্টেটেস্টিকস ইমপ্লিমেন্টেশন সাপোর্ট (এনএসডিএস)',
                'username' => 'PD_NSDS',
                'email' => strtolower('PD_NSDS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_NSDS, 'Project Director')) {
            throw new \RuntimeException('PD_NSDS User Role Assignment Failed');
        }
        $PD_SVRS = $this->userRepository->create(
            [
                'name' => 'স্যাম্পল ভাইটাল রেজিস্ট্রেশন সিস্টেম (এসভিআরএস) ইন ডিজিটাল প্লাটফর্ম প্রকল্প',
                'username' => 'PD_SVRS',
                'email' => strtolower('PD_SVRS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_SVRS, 'Project Director')) {
            throw new \RuntimeException('PD_SVRS User Role Assignment Failed');
        }
        $PD_ICTUS = $this->userRepository->create(
            [
                'name' => 'মেজারমেন্ট আইসিটি এ্যাকসেস এ্যান্ড মিজারিং বাই হাউসহোল্ডস এন্ড ইন্ডিভিজুয়ালস প্রজেক্ট',
                'username' => 'PD_ICTUS',
                'email' => strtolower('PD_ICTUS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($PD_ICTUS, 'Project Director')) {
            throw new \RuntimeException('PD_ICTUS User Role Assignment Failed');
        }

        //Project Information User ID
        $FPO_PSL = $this->userRepository->create(
            [
                'name' => 'দারিদ্র্য পরিস্থিতি পরিমাপে র‌্যাপিড জরিপ ২০২১',
                'username' => 'FPO_PSL',
                'email' => strtolower('FPO_PSL@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($FPO_PSL, 'Focal Point Officer')) {
            throw new \RuntimeException('FPO_PSL User Role Assignment Failed');
        }
        $FPO_BDSCM = $this->userRepository->create(
            [
                'name' => 'BBS Survey, Data Service and Certificate Management',
                'username' => 'FPO_BDSCM',
                'email' => strtolower('FPO_BDSCM@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($FPO_BDSCM, 'Focal Point Officer')) {
            throw new \RuntimeException('FPO_BDSCM User Role Assignment Failed');
        }
        $FPO_NCLS = $this->userRepository->create(
            [
                'name' => 'জাতীয় শিশুশ্রম জরিপ ২০২১ (NCLS)',
                'username' => 'FPO_NCLS',
                'email' => strtolower('FPO_NCLS@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($FPO_NCLS, 'Focal Point Officer')) {
            throw new \RuntimeException('FPO_NCLS User Role Assignment Failed');
        }
        $FPO_SHP = $this->userRepository->create(
            [
                'name' => 'ব্যবসা সম্ভাবনাময় প্রসিদ্ধ, লুপ্তপ্রায় হস্ত ও কারুশিল্পজাত পণ্য জরিপ ২০২২',
                'username' => 'FPO_SHP',
                'email' => strtolower('FPO_SHP@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($FPO_SHP, 'Focal Point Officer')) {
            throw new \RuntimeException('FPO_SHP User Role Assignment Failed');
        }
        $FPO_SADDD = $this->userRepository->create(
            [
                'name' => 'Sex, Age and Disability Disaggregated Data (SADDD) for Disaster Risk Reduction and Climate Change Adaptation কার্যক্রম।',
                'username' => 'FPO_SADDD',
                'email' => strtolower('FPO_SADDD@bbs.com'),
                'password' => Utility::hashPassword('12345678'),
                'mobile' => BanglaConverter::bn2en($faker->phoneNumber),
                'remarks' => 'Director’s User ID',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false,
            ]
        );
        if (! $this->attachUserRoles($FPO_SADDD, 'Focal Point Officer')) {
            throw new \RuntimeException('FPO_SADDD User Role Assignment Failed');
        }
    }

    /**
     * Attach Role to user Model
     *
     * @param  User  $user
     * @return bool
     */
    protected function attachUserRoles(User $user, $role = ''): bool
    {
        $adminRole = Role::findByName($role);
        $this->userRepository->setModel($user);

        return $this->userRepository->manageRoles([$adminRole->id]);
    }
}
