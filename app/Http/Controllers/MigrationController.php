<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xls;

class MigrationController extends Controller
{
    public static function ExcelExtraction($excel, $url = null, $sheet = null, $start = null)
    {
        $reader = new Xlsx();
        if (is_null($url)) {
            $spreadsheet = $reader->load(storage_path('initial/' . $excel));
        } else {
            $spreadsheet = $reader->load(storage_path($url . '/' . $excel));
        }

        if (is_null($sheet)) {
            $worksheet = $spreadsheet->getActiveSheet();
        } else {
            $worksheet = $spreadsheet->getSheet($sheet);
        }
        $array  = [];
        $header = [];
        $head   = true;

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $line = [];
            if (is_null($start)) {
                $i = 0;
            } else {
                $i = $start;
            }

            foreach ($cellIterator as $cell) {
                $val = $cell->getValue();
                if ($head) {
                    $header[] = $val;
                } else {

                    $line[$header[$i]] = ($val === 'NULL') ? null : $val;
                }
                $i++;
            }

            if ($head) {
                $head    = false;
            } else {
                $line['created_at'] = date('Y-m-d H:i:s');
                $line['updated_at'] = date('Y-m-d H:i:s');
                //$line['active'] = true;
                $array[] = $line;
            }
        }

        return $array;
    }
}
