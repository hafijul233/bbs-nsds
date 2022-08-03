<?php

namespace App\Exports\Backend\Organization\Enumerator;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Organization\Enumerator;
use App\Supports\Utility;
use Carbon\Carbon;
use OpenSpout\Common\Exception\InvalidArgumentException;

/**
 * Class EnumeratorWiseExport
 * @package App\Exports\Backend\Organization\Enumerator
 */
class EnumeratorWiseExport extends FastExcelExport
{
    /**
     * EnumeratorExport constructor.
     *
     * @param null $data
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param Enumerator $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            trans('enumerator.Sl. No.', [], 'en') => $row->counter ?? $row->id,
            trans('enumerator.Name (English)', [], 'en') => $row->name ?? null,
            trans('enumerator.Name(Bangla)', [], 'en') => $row->name_bd ?? null,
            trans('enumerator.Gender', [], 'en') => $row->gender->name ?? null,
            trans('enumerator.Date of Birth', [], 'en') => isset($row) ? Carbon::parse($row->dob)->format('d/m/Y') : null,
            trans('enumerator.Age (years)', [], 'en') => isset($row) ? Carbon::parse($row->dob)->age : null,
            trans('enumerator.Father\'s Name', [], 'en') => $row->father ?? null,
            trans('enumerator.Mother\' Name', [], 'en') => $row->mother ?? null,
            trans('enumerator.NID Number', [], 'en') => $row->nid ?? null,
            trans('enumerator.Present Address', [], 'en') => $row->present_address ?? null,
            trans('enumerator.Permanent Address', [], 'en') => $row->permanent_address ?? null,
            trans('enumerator.Education', [], 'en') => $row->examLevel->name ?? null,
            trans('enumerator.Mobile 1', [], 'en') => $row->mobile_1 ?? null,
            trans('enumerator.Mobile 2', [], 'en') => $row->mobile_2 ?? null,
            trans('enumerator.Email', [], 'en') => $row->email ?? null,
            trans('enumerator.Whatsapp Number', [], 'en') => $row->whatsapp ?? null,
            trans('enumerator.Facebook ID', [], 'en') => $row->facebook ?? null,
            trans('enumerator.Revenue staff of BBS', [], 'en') => ucfirst($row->is_employee) ?? null,
            trans('enumerator.Designation', [], 'en') => (($row->is_employee == 'yes') ? $row->designation : 'N/A') ?? null,
            trans('enumerator.Office Name', [], 'en') => (($row->is_employee == 'yes') ? $row->company : 'N/A') ?? null,

            trans('enumerator.Worked Earlier', [], 'en') => (($row->previousPostings()->exists() == true)
                ? Utility::arrayToList($row->previousPostings->pluck('name')->toArray())
                : 'No District Available'),

            trans('enumerator.Want to work in future', [], 'en') => (($row->futurePostings()->exists() == true)
                ? Utility::arrayToList($row->futurePostings->pluck('name')->toArray())
                : 'No District Available'),

            trans('enumerator.Work Experience in BBS', [], 'en') => (($row->surveys()->exists() == true)
                ? Utility::arrayToList($row->surveys->pluck('name')->toArray())
                : 'No Survey Available'),

            trans('enumerator.Created By', [], 'en') => $row->created_by_username ?? 'N/A',
            trans('enumerator.Created Date', [], 'en') => $row->created_at->format(config('backend.datetime'))
        ];

        return $this->formatRow;
    }

    /**
     * @param $data
     * @return string
     */
    private function stateArrayToString($data): string
    {
        $stateArray = array();
        $stateString = 'No District Available';
        if (isset($data)) {
            foreach ($data as $index => $state) {
                $stateArray[] = ($index + 1) . ". " . $state->name ?? null . "\n";
            }
            $stateString = implode("\n", $stateArray);
        }

        return $stateString;
    }

    /**
     * @param $data
     * @return string
     */
    private function surveys($data): string
    {
        $stateArray = array();
        $stateString = 'No Survey Available';
        if (isset($data)) {
            foreach ($data as $index => $survey) {
                $stateArray[] = ($index + 1) . ". " . $survey->name ?? null . "\n";
            }
            $stateString = implode("\n", $stateArray);
        }

        return $stateString;
    }
}

