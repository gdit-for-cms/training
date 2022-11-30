<?php 
namespace Core\Http;

trait ResponseTrait
{
    public function successResponse($data = [], $message = '')
    {
        $res = new Response;
        $result = json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ]);
        $res->setContent($result);
        return $res->send();
    }

    public function errorResponse($message = '')
    {
        $res = new Response;
        $result = json_encode([
            'success' => false,
            'data' => [],
            'message' => $message,
        ]);
        $res->setContent($result);
        $res->setStatus(400);
        return $res->send();
    }
}
