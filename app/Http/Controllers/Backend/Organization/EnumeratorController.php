<?php

namespace App\Http\Controllers\Backend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Organization\CreateEnumeratorRequest;
use App\Http\Requests\Backend\Organization\UpdateEnumeratorRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\CatalogService;
use App\Services\Backend\Setting\ExamLevelService;
use App\Services\Backend\Setting\StateService;
use App\Supports\Constant;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @class EnumeratorController
 */
class EnumeratorController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var EnumeratorService
     */
    private $enumeratorService;

    /**
     * @var SurveyService
     */
    private $surveyService;

    /**
     * @var CatalogService
     */
    private $catalogService;

    /**
     * @var ExamLevelService
     */
    private $examLevelService;

    /**
     * @var StateService
     */
    private $stateService;

    /**
     * EnumeratorController Constructor
     *
     * @param  AuthenticatedSessionService  $authenticatedSessionService
     * @param  EnumeratorService  $enumeratorService
     * @param  SurveyService  $surveyService
     * @param  CatalogService  $catalogService
     * @param  ExamLevelService  $examLevelService
     * @param  StateService  $stateService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
        EnumeratorService $enumeratorService,
        SurveyService $surveyService,
        CatalogService $catalogService,
        ExamLevelService $examLevelService,
        StateService $stateService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
        $this->catalogService = $catalogService;
        $this->examLevelService = $examLevelService;
        $this->stateService = $stateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');
        if (isset(auth()->user()->roles[0]) && in_array(auth()->user()->roles[0]->id, [1, 2])) {
            $filters['created_by'] = '';
        } else {
            $filters['created_by'] = auth()->user()->id;
        }
        $states = $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd'));
        $divisions = $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'division', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd'));
        $surveys = $this->surveyService->getSurveyDropDown(['enabled' => Constant::ENABLED_OPTION]);
        $enumerators = $this->enumeratorService->enumeratorPaginate($filters);

        return view('backend.organization.enumerator.index', [
            'enumerators' => $enumerators,
            'divisions' => $divisions,
            'states' => $states,
            'surveys' => $surveys,
            'request' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function create()
    {
        $enables = [];
        foreach (Constant::ENABLED_OPTIONS as $field => $label) {
            $enables[$field] = __('common.'.$label);
        }

        return view('backend.organization.enumerator.create', [
            'enables' => $enables,
            'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd')),
            'surveys' => $this->surveyService->getSurveyDropDown(['enabled' => Constant::ENABLED_OPTION]),
            'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
            'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEnumeratorRequest  $request
     * @return RedirectResponse
     *
     * @throws Exception|\Throwable
     */
    public function store(CreateEnumeratorRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->enumeratorService->storeEnumerator($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.enumerators.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param    $id
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function show($id)
    {
        if ($enumerator = $this->enumeratorService->getEnumeratorById($id)) {
            return view('backend.organization.enumerator.show', [
                'enumerator' => $enumerator,
                'timeline' => Utility::modelAudits($enumerator),
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function edit($id)
    {
        if ($enumerator = $this->enumeratorService->getEnumeratorById($id)) {
            $enables = [];
            foreach (Constant::ENABLED_OPTIONS as $field => $label) {
                $enables[$field] = __('common.'.$label);
            }

            return view('backend.organization.enumerator.edit', [
                'enumerator' => $enumerator,
                'enables' => $enables,
                'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd')),
                'surveys' => $this->surveyService->getSurveyDropDown(),
                'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
                'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEnumeratorRequest  $request
     * @param    $id
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function update(UpdateEnumeratorRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->enumeratorService->updateEnumerator($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.enumerators.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->enumeratorService->destroyEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.enumerators.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param  Request  $request
     * @return RedirectResponse|void
     *
     * @throws \Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->enumeratorService->restoreEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.enumerators.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return string|StreamedResponse
     *
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws Exception
     */
    public function export(Request $request)
    {
        $counter = 1;

        $filters = $request->except('page');

        $enumeratorExport = $this->enumeratorService->exportEnumerator($filters);

        $filename = 'Enumerator-'.date('Ymd-His').'-'.$request->get('filter').'.'.($filters['format'] ?? 'xlsx');

        return $enumeratorExport->download($filename, function ($enumerator) use ($enumeratorExport, &$counter) {
            $enumerator->counter = $counter;
            $counter++;

            return $enumeratorExport->map($enumerator);
        });
    }

    /**
     * Display a detail of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(Request $request): JsonResponse
    {
        $filters = $request->except('page');

        $enumerators = $this->enumeratorService->getAllEnumerators($filters);

        if (count($enumerators) > 0) {
            foreach ($enumerators as $index => $enumerator) {
                $enumerators[$index]->update_route = route('backend.organization.enumerators.update', $enumerator->id);
                $enumerators[$index]->survey_id = $enumerator->surveys->pluck('id')->toArray();
                $enumerators[$index]->prev_post_state_id = $enumerator->previousPostings->pluck('id')->toArray();
                $enumerators[$index]->future_post_state_id = $enumerator->futurePostings->pluck('id')->toArray();
                unset($enumerators[$index]->surveys, $enumerators[$index]->previousPostings, $enumerators[$index]->futurePostings);
            }

            $jsonReturn = ['status' => true, 'data' => $enumerators];
        } else {
            $jsonReturn = ['status' => false, 'data' => []];
        }

        return response()->json($jsonReturn, 200);
    }
}
