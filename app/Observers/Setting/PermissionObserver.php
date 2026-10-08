<?php

namespace App\Observers\Setting;

use App\Models\Setting\Permission;
use App\Notifications\Setting\Permission\PermissionCreatedNotification;
use App\Notifications\Setting\Permission\PermissionDeletedNotification;
use App\Services\Backend\Setting\UserService;

class PermissionObserver
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the Permission "created" event.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function created(Permission $permission)
    {
        // send notification to all super admin about new user
        if ($admins = $this->userService->getUsersByRoleName('Super Administrator')) {
            foreach ($admins as $admin) {
                $admin->notify(new PermissionCreatedNotification($permission));
            }
        }
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @return void
     */
    public function updated(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function deleted(Permission $permission)
    {
        // send notification to all super admin about new user
        if ($admins = $this->userService->getUsersByRoleName('Super Administrator')) {
            foreach ($admins as $admin) {
                $admin->notify(new PermissionDeletedNotification($permission));
            }
        }
    }

    /**
     * Handle the Permission "restored" event.
     *
     * @return void
     */
    public function restored(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        //
    }
}
