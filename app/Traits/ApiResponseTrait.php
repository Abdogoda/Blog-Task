<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait{
  public function success(array $dataArray = [], string $message = 'Success', int $statusCode = 200): JsonResponse{
    $response = [
    'message' => $message
    ];
    foreach ($dataArray as $key => $data) {
    if ($key && $data) {
        $response[$key] = $data;
    }
  }

    return response()->json($response, $statusCode);
  }

  public function error(string $message = 'Error', int $statusCode = 400, array $errors = []): JsonResponse{
    $response = [
    'message' => $message
    ];
    if($errors){
    $response['errors'] = $errors;
    }
    return response()->json($response, $statusCode);
  }
}