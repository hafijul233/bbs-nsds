<?php

namespace App\Repositories\Eloquent\Backend\Organization;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Backend\Organization\Enumerator;
use App\Services\Auth\AuthenticatedSessionService;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @class EnumeratorRepository
 * @package App\Repositories\Eloquent\Backend\Organization
 */
class EnumeratorRepository extends EloquentRepository
{
    /**
     * EnumeratorRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new Enumerator);
    }

    /**
     * Search Function
     *
     * @param array $filters
     * @param bool $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        $query = $this->getQueryBuilder();

        $query->leftJoin('users', 'users.id', '=', 'enumerators.created_by');

        if (!empty($filters['search'])) :
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('enabled', 'like', "%{$filters['search']}%")
                ->orWhere('nid', 'like', "%{$filters['search']}%")
                ->orWhere('mobile_1', 'like', "%{$filters['search']}%")
                ->orWhere('mobile_2', 'like', "%{$filters['search']}%")
                ->orWhere('email', 'like', "%{$filters['search']}%")
                ->orWhere('present_address', 'like', "%{$filters['search']}%")
                ->orWhere('permanent_address', 'like', "%{$filters['search']}%");
        endif;

        if (!empty($filters['enabled'])) :
            $query->where('enabled', '=', $filters['enabled']);
        endif;

        if (!empty($filters['nid'])) :
            $query->where('nid', '=', $filters['nid']);
        endif;

        if (!empty($filters['survey_id'])) :
            $query->leftJoin('enumerator_survey', 'enumerator_survey.enumerator_id', '=', 'enumerators.id');
            $query->where('enumerator_survey.survey_id', '=', $filters['survey_id']);
        endif;

        //TODO
        if (isset($filters['division_id']) && !empty($filters['division_id'])) :
            if (!empty($filters['work_options']) && $filters['work_options'] == Constant::WORKED_EARLIER) {
                $query->leftJoin('enumerator_previous_state', 'enumerator_previous_state.enumerator_id', '=', 'enumerators.id');
                $query->leftJoin('states', 'states.id', '=', 'enumerator_previous_state.state_id');
                $query->where('states.division_id', '=', $filters['division_id']);

                if (isset($filters['prev_post_state_id']) && !empty($filters['prev_post_state_id'])) {
                    $query->where('states.id', '=', $filters['prev_post_state_id']);
                    unset($filters['prev_post_state_id']);
                }
            } else if (!empty($filters['work_options']) && $filters['work_options'] == Constant::WORK_IN_FUTURE) {
                $query->leftJoin('enumerator_future_state', 'enumerator_future_state.enumerator_id', '=', 'enumerators.id');
                $query->leftJoin('states', 'states.id', '=', 'enumerator_future_state.state_id');
                $query->where('states.division_id', '=', $filters['division_id']);

                if (isset($filters['future_post_state_id']) && !empty($filters['future_post_state_id'])) {
                    $query->where('states.id', '=', $filters['future_post_state_id']);
                    unset($filters['future_post_state_id']);
                }
            }

        endif;

        if (isset($filters['prev_post_state_id']) && !empty($filters['prev_post_state_id'])) :
            $query->leftJoin('enumerator_previous_state', 'enumerator_previous_state.enumerator_id', '=', 'enumerators.id');
            $query->where('enumerator_previous_state.state_id', '=', $filters['prev_post_state_id']);
        endif;

        if (isset($filters['future_post_state_id']) && !empty($filters['future_post_state_id'])) :
            $query->leftJoin('enumerator_future_state', 'enumerator_future_state.enumerator_id', '=', 'enumerators.id');
            $query->where('enumerator_future_state.state_id', '=', $filters['future_post_state_id']);
        endif;

        if (isset($filters['is_total_survey']) && $filters['is_total_survey'] == true) {
            $query->leftJoin(
                DB::raw(
                    '(SELECT enumerator_id, COUNT(survey_id) AS totalSurvey FROM enumerator_survey GROUP BY enumerator_id) AS ES'
                ),
                function ($join) {
                    $join->on('ES.enumerator_id', '=', 'enumerators.id');
                }
            );
        }

        if (!empty($filters['created_by'])) :
            $query->where('created_by', '=', $filters['created_by']);
        endif;

        if (!empty($filters['sort']) && !empty($filters['direction'])) :
            $query->orderBy($filters['sort'], $filters['direction']);
        endif;

        if ($is_sortable == true) :
            $query->sortable();
        endif;

        if (AuthenticatedSessionService::isSuperAdmin()) :
            $query->withTrashed();
        endif;

        $select[] = DB::raw('users.username as created_by_username');
        if (isset($filters['is_total_survey']) && $filters['is_total_survey'] == true) {
            $select[] = DB::raw('IFNULL(ES.totalSurvey,0) AS totalSurvey');
        }
        $select[] = 'enumerators.*';
        $query->select($select);
        return $query;
    }

    /**
     * Pagination Generator
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return LengthAwarePaginator
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
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return Builder[]|Collection
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
