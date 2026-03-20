<?php

declare(strict_types=1);

namespace App\Services;

/**
 * BaseService
 * 
 * A foundational class for all business logic services.
 * Provides access to common utilities and logging.
 */
abstract class BaseService
{
    /**
     * Common service initialization can be handled here.
     * All child services should use constructor injection for their dependencies.
     */
    public function __construct()
    {
    }
}
