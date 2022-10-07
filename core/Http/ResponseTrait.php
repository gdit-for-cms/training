<?php 
namespace Core\Http;

trait ResponseTrait
{
    public function successResponse($data = [] , $message = '', $status = 200)
    {
        return json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ] ,$status);
    }
    public function errorResponse($message = '' ,$status = 400)
    {
        return json_encode([
            'success' => false,
            'data' => [],
            'message' => $message,
        ], $status);
    }
}

?>