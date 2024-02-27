<?php

namespace App\Controllers;

use App\Models\DetailMeal;
use App\Models\Meal;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use Core\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailMealController extends AppController {
    use ResponseTrait;

    public array $data_ary;

    function displayGeneralDetailAction() {
        $detail_meal = new DetailMeal;
        $meal = new Meal;
        $this->data_ary['meals'] = $meal->getMealsByUser();
        if (!$this->data_ary['meals']) {
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/home/index';
            if (strpos($referer, '/detail-meal/display-general-detail')) {
                header('Location: /home/index');
                exit;
            } else {
                $_SESSION['non_meal'] = TRUE;
                header('Location: ' . $referer);
                exit;
            }
        }
        $meal_id = 0;
        $flag = FALSE;
        if (isset($_GET['meal_id']) && $_GET['meal_id'] > 0) {
            $meal_id = $_GET['meal_id'];
            foreach ($this->data_ary['meals'] as $element) {
                if ($element['id'] == $meal_id) {
                    $this->data_ary['status'] = $element['closed'];
                    $this->data_ary['store_id'] = $element['store_id'];
                    $this->data_ary['store_name'] = $element['store_name'];
                    $this->data_ary['is_free'] = $element['is_free'];
                    $flag = TRUE;
                    break;
                }
            }
        }
        if (!$flag) {
            $meal_id = $this->data_ary['meals'][0]['id'];
            $this->data_ary['status'] = $this->data_ary['meals'][0]['closed'];
            $this->data_ary['store_id'] = $this->data_ary['meals'][0]['store_id'];
            $this->data_ary['store_name'] = $this->data_ary['meals'][0]['store_name'];
            $this->data_ary['is_free'] = $this->data_ary['meals'][0]['is_free'];
        }
        $this->data_ary['meal_id'] = $meal_id;
        $this->data_ary['detail_meals'] = $detail_meal->getGeneralDetailMealByMealId($meal_id);
        $this->data_ary['content'] = '/meal/manager_meal';
        $this->data_ary['title'] = 'Quản lý đơn';
        View::render('/layouts/master.php', $this->data_ary);
        exit;
    }

    public function addOrderAction() {
        $json = file_get_contents('php://input');
        $orderData = json_decode($json, true);

        $detailMeal = new DetailMeal();

        try {
            $result = $detailMeal->processOrder($orderData);
            header('Content-Type: application/json');
            return $this->successResponse($result, 'Had response');
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            return $this->errorResponse($e->getMessage());
            exit;
        }
    }

    public function showAction(Request $request) {
        $get = $request->getGet();
        $meal_id = $get->get('meal_id');

        $meal = new Meal();
        $detail_meal = $meal->getDetailMealById($meal_id);
        if (empty($detail_meal)) {
            header('Location: /404.php');
            exit;
        }


        $object_detail_meal = new DetailMeal();
        $data = $object_detail_meal->getDetailsByUserAndMeal($meal_id);
        $this->data_ary['meals'] = $data;
        $this->data_ary['detail_meal'] = $detail_meal;

        $this->data_ary['content'] = '/detail_meal/show';
        View::render('/layouts/master.php', $this->data_ary);
        exit;
    }

    public function exportAction() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $meal_id = $data['meal_id'] ?? null;

        $object_detail_meal = new DetailMeal();

        $meals = $object_detail_meal->getDetailsByUserAndMeal($meal_id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the cell content and style for the header row
        $headers = ['#', 'Tên người đặt', 'Món', 'Giá', 'Số lượng', 'Tổng', 'Note'];
        $column = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($column, 1, $header);
            $sheet->getStyleByColumnAndRow($column, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $column++;
        }

        // Fill data
        $row = 2;
        foreach ($meals as $index => $item) {
            $sheet->setCellValueByColumnAndRow(1, $row, $index + 1);
            $sheet->setCellValueByColumnAndRow(2, $row, $item['display_name']);
            $sheet->setCellValueByColumnAndRow(3, $row, $item['food_name']);
            $sheet->setCellValueByColumnAndRow(4, $row, $item['price']);
            $sheet->setCellValueByColumnAndRow(5, $row, $item['amount']);
            $sheet->setCellValueByColumnAndRow(6, $row, $item['price'] * $item['amount']);
            $sheet->setCellValueByColumnAndRow(7, $row, $item['describes'] ?: 'N/A');
            $row++;
        }

        // Set HTTP headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="meals.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    protected function after() {
    }
}
