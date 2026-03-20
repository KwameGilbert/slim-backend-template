<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helper\ResponseHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

/**
 * BaseController
 * 
 * Provides common functionality for all controllers,
 * including standardized response handling.
 */
abstract class BaseController
{
    /**
     * Return a success JSON response
     */
    protected function success(Response $response, string $message, $data = [], int $status = 200): Response
    {
        return ResponseHelper::success($response, $message, $data, $status);
    }

    /**
     * Return an error JSON response
     */
    protected function error(Response $response, string $message, int $status = 400, $errors = null): Response
    {
        return ResponseHelper::error($response, $message, $status, $errors);
    }

    /**
     * Extract metadata from the request (IP, User Agent, etc.)
     */
    protected function getRequestMetadata($request): array
    {
        $serverParams = $request->getServerParams();

        return [
            'ip_address' => $serverParams['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $request->getHeaderLine('User-Agent'),
            'device_name' => $request->getHeaderLine('X-Device-Name') ?: null
        ];
    }
}
