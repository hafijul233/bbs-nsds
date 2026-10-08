<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\CityExport;
use App\Models\Backend\Setting\City;
use App\Repositories\Eloquent\Backend\Setting\CityRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class CityService
 */
class CityService extends Service
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * CityService constructor.
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->cityRepository->itemsPerPage = 10;
    }

    /**
     * Get All City models as collection
     *
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getAllCities(array $filters = [], array $eagerRelations = [])
    {
        return $this->cityRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create City Model Pagination
     *
     *
     * @throws Exception
     */
    public function cityPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->cityRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show City Model
     *
     * @param  int  $id
     * @return mixed
     *
     * @throws Exception
     */
    public function getCityById($id, bool $purge = false)
    {
        return $this->cityRepository->show($id, $purge);
    }

    /**
     * Save City Model
     *
     *
     * @throws Exception
     * @throws Throwable
     */
    public function storeCity(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newCity = $this->cityRepository->create($inputs);
            if ($newCity instanceof City) {
                DB::commit();

                return ['status' => true, 'message' => __('New City Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('New City Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->cityRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Update City Model
     *
     *
     * @throws Throwable
     */
    public function updateCity(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $city = $this->cityRepository->show($id);
            if ($city instanceof City) {
                if ($this->cityRepository->update($inputs, $id)) {
                    DB::commit();

                    return ['status' => true, 'message' => __('City Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
                } else {
                    DB::rollBack();

                    return ['status' => false, 'message' => __('City Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
                }
            } else {
                return ['status' => false, 'message' => __('City Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->cityRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Destroy City Model
     *
     *
     * @throws Throwable
     */
    public function destroyCity($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->cityRepository->delete($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('City is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('City is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->cityRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Restore City Model
     *
     *
     * @throws Throwable
     */
    public function restoreCity($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->cityRepository->restore($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('City is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('City is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->cityRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Export Object for Export Download
     *
     *
     * @throws Exception
     */
    public function exportCity(array $filters = []): CityExport
    {
        return new CityExport($this->cityRepository->getWith($filters));
    }

    /**
     * @throws Exception
     */
    public function getCityDropdown(array $filters = []): array
    {
        $filters = array_merge([
            'enabled' => 'yes',
        ], $filters);

        $cities = $this->getAllCities($filters);
        $cityArray = [];

        foreach ($cities as $city) {
            $cityArray[$city->id] = $city->name;
        }

        return $cityArray;
    }
}
