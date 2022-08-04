<?php

namespace App\Exports\Backend\Organization\Enumerator;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Organization\Enumerator;
use App\Supports\Utility;
use Carbon\Carbon;
use OpenSpout\Common\Exception\InvalidArgumentException;

/**
 * Class SurveyWiseExport
 */
class SurveyWiseExport extends FastExcelExport
{
    /**
     * EnumeratorExport constructor.
     *
     * @param  null  $data
     *
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param  Enumerator  $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            trans('enumerator.Sl. No.', [], 'en') => $row->counter ?? $row->id,
            trans('enumerator.Name', [], 'en') => $row->name ?? null,
            trans('enumerator.Name(Bangla)', [], 'en') => $row->name_bd ?? null,
            trans('enumerator.Gender', [], 'en') => $row->gender->name ?? null,
            trans('enumerator.Date of Birth', [], 'en') => isset($row) ? Carbon::parse($row->dob)->format('d/m/Y') : null,
            trans('enumerator.Age', [], 'en') => isset($row) ? Carbon::parse($row->dob)->age : null,
            trans('enumerator.NID Number', [], 'en') => $row->nid ?? null,
            trans('enumerator.Present Address', [], 'en') => $row->present_address ?? null,
            trans('enumerator.Mobile 1', [], 'en') => $row->mobile_1 ?? null,
            trans('enumerator.Email', [], 'en') => $row->email ?? null,
            trans('enumerator.Whatsapp Number', [], 'en') => $row->whatsapp ?? null,
            trans('enumerator.Facebook ID', [], 'en') => $row->facebook ?? null,
            trans('enumerator.Total Survey', [], 'en') => $row->totalSurvey ?? null,
            trans('enumerator.Survey Name', [], 'en') => (($row->surveys()->exists() == true)
                ? Utility::arrayToList($row->surveys->pluck('name')->toArray())
                : 'No Survey Available'),
        ];

        return $this->formatRow;
    }
}
