<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\DistrictRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\Setting\DistrictService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DistrictController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var DistrictService
     */
    private $districtService;

    /**
     * @var CountryService
     */
    private $stateService;

    /**
     * @param  AuthenticatedSessionService  $authenticatedSessionService
     * @param  DistrictService  $districtService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
        DistrictService $districtService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->districtService = $districtService;
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
        $districts = $this->districtService->districtPaginate($filters);

        return view('backend.setting.district.index', [
            'districts' => $districts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function create()
    {
        return view('backend.setting.district.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DistrictRequest  $request
     * @return RedirectResponse
     *
     * @throws Exception|\Throwable
     */
    public function store(DistrictRequest $request): RedirectResponse
    {
        $confirm = $this->districtService->storeDistrict($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.settings.districts.index');
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
        if ($district = $this->districtService->getDistrictById($id)) {
            return view('backend.setting.district.show', [
                'district' => $district,
                'timeline' => Utility::modelAudits($district),
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
     * @throws Exception
     */
    public function edit($id)
    {
        if ($district = $this->districtService->getDistrictById($id)) {
            return view('backend.setting.district.edit', [
                'district' => $district,
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DistrictRequest  $request
     * @param    $id
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function update(DistrictRequest $request, $id): RedirectResponse
    {
        $confirm = $this->districtService->updateDistrict($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.settings.districts.index');
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
            $confirm = $this->districtService->destroyDistrict($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.settings.districts.index');
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
            $confirm = $this->districtService->restoreDistrict($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.settings.districts.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return string|StreamedResponse
     *
     * @throws Exception
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');

        $districtExport = $this->districtService->exportDistrict($filters);

        $filename = 'District-'.date('Ymd-His').'.'.($filters['format'] ?? 'xlsx');

        return $districtExport->download($filename, function ($district) use ($districtExport) {
            return $districtExport->map($district);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.setting.district.import');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function importBulk(Request $request)
    {
        $filters = $request->except('page');
        $districts = $this->districtService->getAllDistricts($filters);

        return view('backend.setting.district.index', [
            'districts' => $districts,
        ]);
    }

    /**
     * Display a detail of the resource.
     *
     * @return StreamedResponse|string
     *
     * @throws Exception
     */
    public function print(Request $request)
    {
        $filters = $request->except('page');

        $districtExport = $this->districtService->exportDistrict($filters);

        $filename = 'District-'.date('Ymd-His').'.'.($filters['format'] ?? 'xlsx');

        return $districtExport->download($filename, function ($district) use ($districtExport) {
            return $districtExport->map($district);
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

        $districts = $this->districtService->getAllDistricts($filters)->toArray();

        if (count($districts) > 0) {
            $jsonReturn = ['status' => true, 'data' => $districts];
        } else {
            $jsonReturn = ['status' => false, 'data' => []];
        }

        return response()->json($jsonReturn, 200);
    }
}
