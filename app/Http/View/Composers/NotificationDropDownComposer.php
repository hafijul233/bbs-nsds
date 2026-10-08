<?php

namespace App\Http\View\Composers;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\View\View;

class NotificationDropDownComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view) {}
}
