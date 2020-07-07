<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    /**
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @param array $context
     *
     * @return Response
     */
    protected function success(
        $data,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        array $context = []
    ): Response {
        return $this->json(
            [
                'data' => $data,
                'status' => 'success',
            ],
            $statusCode,
            $headers,
            $context
        );
    }
}
