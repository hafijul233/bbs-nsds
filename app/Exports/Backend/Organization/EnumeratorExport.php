<?php

namespace App\Exports\Backend\Organization;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Organization\Enumerator;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Carbon\Carbon;

/**
 * @class EnumeratorExport
 * @package App\Exports\Backend\Organization
 */
class EnumeratorExport extends FastExcelExport
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
            '#' => $row->id,
            trans('Name (in English)', [], 'en') => $row->name ?? null,
            trans('Name(Bangla)', [], 'en') => $row->name_bd ?? null,
            trans('Gender', [], 'en') => $row->gender->name ?? null,
            trans('Date of Birth', [], 'en') => isset($row) ? Carbon::parse($row->dob)->format('d/m/Y') : null,
            trans('Father Name', [], 'en') => $row->father ?? null,
            trans('Mother Name', [], 'en') => $row->mother ?? null,
            trans('NID Number', [], 'en') => $row->nid ?? null,
            trans('Present Address', [], 'en') => $row->present_address ?? null,
            trans('Permanent Address', [], 'en') => $row->permanent_address ?? null,
            trans('Education', [], 'en') => $row->examLevel->name ?? null,
            trans('Mobile 1', [], 'en') => $row->mobile_1 ?? null,
            trans('Mobile 2', [], 'en') => $row->mobile_2 ?? null,
            trans('Email', [], 'en') => $row->email ?? null,
            trans('Whatsapp Number', [], 'en') => $row->whatsapp ?? null,
            trans('Facebook ID', [], 'en') => $row->facebook ?? null,
            trans('Worked Earlier', [], 'en') => $this->stateArrayToString($row->previousPostings) ?? null,
            trans('Work in Future', [], 'en') => $this->stateArrayToString($row->futurePostings) ?? null,
            trans('Revenue staff of BBS', [], 'en') => ucfirst($row->is_employee) ?? null,
            trans('Designation', [], 'en') => (($row->is_employee == 'yes') ? $row->designation :   'N/A') ?? null,
            trans('Company Name', [], 'en') => (($row->is_employee == 'yes') ? $row->company :   'N/A') ?? null,
            'Enabled' => ucfirst(($row->enabled ?? '')),
            'Created' => $row->created_at->format(config('backend.datetime'))
        ];

        /*$this->getSupperAdminColumns($row);*/

        return $this->formatRow;
    }

    /**
     * @param $data
     * @return string
     */
    public function stateArrayToString($data): string
    {
        $stateArray = array();
        $stateString = 'No District Available';
        if(isset($data)){
            foreach($data as $state){
                $stateArray[] = $state->name;
            }
            $stateString = implode(',', $stateArray);
        }

        return $stateString;
    }
}

