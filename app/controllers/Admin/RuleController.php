<?php

namespace App\Controllers\Admin;

use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\models\Rule;
use App\Models\TypeRule;
use  PhpOffice\PhpSpreadsheet\Spreadsheet;
use  PhpOffice\PhpSpreadsheet\Reader\Xls;
use  PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;




class RuleController extends AppController
{
    use ResponseTrait;

    public $title = 'Rules';

    public object $obj_rule_model;
    public object $obj_type_rule_model;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_rule_model = new Rule;
        $this->obj_type_rule_model = new TypeRule;
    }

    public function indexAction(Request $request)
    {
        $types_rule = $this->obj_type_rule_model->getAll();
        $this->data_ary['types_rule'] = $types_rule;
        $this->data_ary['content'] = "rule/index";
    }

    public function rulesDetailAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('id');
        $type_rule_name = $request->getGet()->get('name');

        $rules_by_type_ary = $this->obj_rule_model->getBy('type_rule_id', '=', $type_rule_id, '*');


        $this->data_ary['rules_by_type_ary'] = $rules_by_type_ary;
        $this->data_ary['type_rule_name'] = $type_rule_name;
        $this->data_ary['type_rule_id'] = $type_rule_id;
        $this->data_ary['content'] = "rule/detail";
    }
    public function importAction(Request $request)
    {
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['file_upload']['name']) && in_array($_FILES['file_upload']['type'], $file_mimes)) {
            $inputFileType = IOFactory::identify($_FILES['file_upload']['tmp_name']);

            if ('xlsx' == lcfirst($inputFileType)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ('xls' == lcfirst($inputFileType)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else if ('csv' == lcfirst($inputFileType)) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }

            $spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
            $sheetData_ary = $spreadsheet->getActiveSheet()->toArray();
            if (!empty($sheetData_ary)) {
                try {
                    unset($sheetData_ary[0]);
                    if (count($this->obj_type_rule_model->getBy('name', '=', $type_rule_name, '*')) == 0) {
                        $this->obj_type_rule_model->create(['name' => $type_rule_name]);
                        $type_rule = $this->obj_type_rule_model->getBy('name', '=', $type_rule_name, '*');

                        foreach ($sheetData_ary as $row) {
                            if (!empty($row['1'])) {
                                $large_category = $row[1];
                                $middle_category = $row[2];
                                $small_category = $row[3];
                                $content = $row[4];
                                $detail = $row[5];
                                $note = $row[6];
                                $this->obj_rule_model->create(
                                    [
                                        'type_rule_id' => $type_rule[0]['id'],
                                        'large_category' => $large_category,
                                        'middle_category' => $middle_category,
                                        'small_category' => $small_category,
                                        'content' => $content,
                                        'detail' => $detail,
                                        'note' => $note,
                                    ]
                                );
                            }
                        }
                    } else {
                    }

                    $this->data_ary['content'] = "rule/index";
                } catch (\Throwable $th) {
                    return $this->errorResponse($th->getMessage());
                };
            }
        }
        header('Location: /admin/rule/index');
    }
    public function exportAction(Request $request)
    {
        $type_rule_id = $request->getPost()->get('type_rule_id');
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $rules_by_type_ary = $this->obj_rule_model->getBy('type_rule_id', '=', $type_rule_id, '*');
        $spreadsheet = IOFactory::load('template.xlsx');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'No');
        // $sheet->setCellValue('B1', 'Large category');
        // $sheet->setCellValue('C1', 'Middle category');
        // $sheet->setCellValue('D1', 'Small category');
        // $sheet->setCellValue('E1', 'Content');
        // $sheet->setCellValue('F1', 'Detail');
        // $sheet->setCellValue('G1', 'Note');
        // // $row_count = 2;
        // // foreach ($rules_by_type_ary as $row) {
        // //     $sheet->setCellValue('A' . $row_count, $row_count - 1);
        // //     $sheet->setCellValue('B' . $row_count, $row['large_category']);
        // //     $sheet->setCellValue('C' . $row_count, $row['middle_category']);
        // //     $sheet->setCellValue('D' . $row_count, $row['small_category']);
        // //     $sheet->setCellValue('E' . $row_count, $row['content']);
        // //     $sheet->setCellValue('F' . $row_count, $row['detail']);
        // //     $sheet->setCellValue('G' . $row_count, $row['note']);
        // //     $row_count++;
        // // }
        $writer = new Xlsx($spreadsheet);
        $file_name = str_replace(' ', '_', $type_rule_name);
        $file_name .= date('Ymd') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="' . $file_name . '"');
        $writer->save('php://output');
    }
}
