<?php

namespace App\Repositories\Eloquent\Backend\Setting;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Backend\Setting\State;
use App\Services\Auth\AuthenticatedSessionService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class StateRepository extends EloquentRepository
{
    /**
     * PermissionRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new State);
    }

    /**
     * Search Function for Permissions
     *
     * @param  array  $filters
     * @param  bool  $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        $query = $this->getQueryBuilder();

        if (! empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('enabled', '=', "%{$filters['search']}%");
        }

        if (! empty($filters['enabled'])) {
            $query->where('enabled', '=', $filters['enabled']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', '=', $filters['type']);
        }

        if (! empty($filters['sort'])) {
            $query->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if ($is_sortable == true) {
            $query->sortable();
        }

        if (isset($filters['country']) && ! empty($filters['country'])) {
            if (is_array($filters['country'])) {
                $query->whereIn('country_id', $filters['country']);
            } else {
                $query->where('country_id', $filters['country']);
            }
        }

        if (isset($filters['id']) && ! empty($filters['id'])) {
            if (is_array($filters['id'])) {
                $query->whereIn('id', $filters['id']);
            } else {
                $query->where('id', $filters['id']);
            }
        }

        if (AuthenticatedSessionService::isSuperAdmin()) {
            $query->withTrashed();
        }

        return $query;
    }

    /**
     * Pagination Generator
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @param  bool  $is_sortable
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function paginateWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false): LengthAwarePaginator
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->paginate($this->itemsPerPage);
        }
    }

    /**
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @param  bool  $is_sortable
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false)
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->get();
        }
    }
}
