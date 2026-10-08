<?php

namespace App\Interfaces;

use OpenSpout\Writer\Common\Creator\Style\BorderBuilder;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;

interface ExportInterface
{
    /**
     * Modify Output Row Cells
     */
    public function map($row): array;

    /**
     * @return mixed
     */
    public function setBorderStyle(BorderBuilder $borderBuilder);

    /**
     * @return mixed
     */
    public function setRowStyle(StyleBuilder $styleBuilder);

    /**
     * @return mixed
     */
    public function setHeadingStyle(StyleBuilder $styleBuilder);

    /**
     * Returns all super admin columns
     *
     * @return void
     */
    public function getSupperAdminColumns($row);
}
