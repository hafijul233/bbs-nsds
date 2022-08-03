<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\DistrictExport;
use App\Models\Backend\Setting\District;
use App\Repositories\Eloquent\Backend\Setting\DistrictRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class DistrictService
 */
class DistrictService extends Service
{
    /**
     * @var DistrictRepository
     */
    private $districtRepository;

    /**
     * DistrictService constructor.
     *
     * @param  DistrictRepository  $districtRepository
     */
    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
        $this->districtRepository->itemsPerPage = 10;
    }

    /**
     * Get All District models as collection
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getAllDistricts(array $filters = [], array $eagerRelations = [])
    {
        return $this->districtRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create District Model Pagination
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function districtPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->districtRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show District Model
     *
     * @param  int  $id
     * @param  bool  $purge
     * @return mixed
     *
     * @throws Exception
     */
    public function getDistrictById($id, bool $purge = false)
    {
        return $this->districtRepository->show($id, $purge);
    }

    /**
     * Save District Model
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     * @throws Throwable
     */
    public function storeDistrict(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newDistrict = $this->districtRepository->create($inputs);
            if ($newDistrict instanceof District) {
                DB::commit();

                return ['status' => true, 'message' => __('New District Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('New District Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->districtRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Update District Model
     *
     * @param  array  $inputs
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function updateDistrict(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $district = $this->districtRepository->show($id);
            if ($district instanceof District) {
                if ($this->districtRepository->update($inputs, $id)) {
                    DB::commit();

                    return ['status' => true, 'message' => __('District Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
                } else {
                    DB::rollBack();

                    return ['status' => false, 'message' => __('District Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
                }
            } else {
                return ['status' => false, 'message' => __('District Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->districtRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Destroy District Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function destroyDistrict($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->districtRepository->delete($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('District is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('District is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->districtRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Restore District Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function restoreDistrict($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->districtRepository->restore($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('District is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('District is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->districtRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param  array  $filters
     * @return DistrictExport
     *
     * @throws Exception
     */
    public function exportDistrict(array $filters = []): DistrictExport
    {
        return new DistrictExport($this->districtRepository->getWith($filters));
    }

    /**
     * @param  array  $filters
     * @return array
     *
     * @throws Exception
     */
    public function getDistrictDropdown(array $filters = [], bool $showNative = false): array
    {
        $filters = array_merge([
            'enabled' => 'yes',
        ], $filters);

        $districts = $this->getAllDistricts($filters);
        $districtArray = [];

        foreach ($districts as $district) {
            $districtArray[$district->id] = ($showNative == false) ? $district->name : $district->native;
        }

        return $districtArray;
    }
}
