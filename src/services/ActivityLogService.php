<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog; // Assume a generic AuditLog model exists or create it

/**
 * ActivityLogService
 * 
 * A generic service for tracking user and system activities.
 * Can be linked to an AuditLog model.
 */
class ActivityLogService extends BaseService
{
    /**
     * Log an activity to the database or a log file.
     * 
     * @param int|null $userId ID of the user performing the action
     * @param string $action The action performed (e.g., 'login', 'create_user')
     * @param string|null $resourceType The type of resource affected (e.g., 'User', 'Order')
     * @param int|null $resourceId The ID of the resource affected
     * @param string|null $description A human-readable description of the activity
     * @param array|null $metadata Additional contextual data
     */
    public function log(
        ?int $userId, 
        string $action, 
        ?string $resourceType = null, 
        ?int $resourceId = null, 
        ?string $description = null,
        ?array $metadata = null
    ): void {
        // Implementation for logging activity
        // Example: AuditLog::create([...]);
        
        error_log("Activity: USER_ID: $userId, ACTION: $action, RESOURCE: $resourceType($resourceId), DESC: $description");
    }
}
