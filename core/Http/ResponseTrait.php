<?php

namespace Core\Http;

trait ResponseTrait {
    public function successResponse($data = [], $message = '') {
        $res = new Response;
        $result = json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ]);
        $res->setContent($result);
        return $res->send();
    }

    public function errorResponse($message = '', $data = []) {
        $res = new Response;
        $result = json_encode([
            'success' => false,
            'data' => $data,
            'message' => $message,
        ]);
        $res->setContent($result);
        $res->setStatus(400);
        return $res->send();
    }

    public function responseFileQuery($status, $message, $result = []) {
        $res = [
            "success" => $status,
            "message" => $message,
            "result" => $result,
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }

    public function responseFileObj($status, $message, $result = [], $object) {
        $res = [
            "success" => $status,
            "message" => $message,
            "result" => $result,
            "object" => $object,
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }
}
