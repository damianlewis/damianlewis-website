<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Response;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * @param  array  $data
     * @param  array  $headers
     * @param  int  $options
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = [], int $options = 0): JsonResponse
    {
        return Response::json($data, $this->getStatusCode(), $headers, $options);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    public function respondedNotFound(string $message = 'Not found'): JsonResponse
    {
        $this->setStatusCode(404);

        return $this->respondWithError($message);
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
//    public function respondInternalServerError(string $message = 'Internal server error'): JsonResponse
//    {
//        $this->setStatusCode(500);
//
//        return $this->respondWithError($message);
//    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param  int  $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    protected function respondWithError(string $message): JsonResponse
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ]);
    }
}
