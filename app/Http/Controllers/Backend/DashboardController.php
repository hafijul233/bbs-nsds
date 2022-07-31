<?php

namespace App\Http\Controllers\Backend;

use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\UserService;
use App\Supports\Constant;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var EnumeratorService
     */
    private $enumeratorService;
    /**
     * @var SurveyService
     */
    private $surveyService;

    /**
     * DashboardController constructor.
     * @param UserService $userService
     * @param EnumeratorService $enumeratorService
     * @param SurveyService $surveyService
     */
    public function __construct(UserService $userService,
                                EnumeratorService $enumeratorService,
                                SurveyService $surveyService)
    {

        $this->userService = $userService;
        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
    }

    /**
     * @param Request $request
     * @return array|Application|Factory|View|mixed
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $requestUser = Auth::user();

        $request->created_by = empty(array_intersect(
            $requestUser->roles
                ->pluck('id')
                ->toArray(),
            Constant::EXECUTIVE_ROLES
        ))
            ? $requestUser->id
            : null;

        return view('backend.dashboard', [
            'users' => $this->userService->getAllUsers(['role' => Constant::VISIBLE_ROLES])->count(),
            'enumerators' => $this->enumeratorService->getAllEnumerators($request->all())->count(),
            'surveys' => $this->surveyService->getAllSurveys()->count()
        ]);
    }

}
