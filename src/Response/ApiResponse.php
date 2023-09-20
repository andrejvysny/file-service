<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse
{
    public function __construct(
        mixed $data = null,
        int $status = Response::HTTP_OK,
        ?string $message = null,
        array $errors = [],
        array $headers = [],
        bool $json = false
    ) {
        parent::__construct($this->format($data, $status, $message, $errors), $status, $headers, $json);
    }


    private function format(mixed $data, int $code, ?string $message, array $errors): array
    {
        return [
            'code' => $code,
            'data' => $data,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}
