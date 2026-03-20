<?php

/**
 * Service Container Registration
 * 
 * Registers all services, controllers, and middleware with the DI container
 */

use App\Services\EmailService;
use App\Services\SMSService;
use App\Services\AuthService;
use App\Services\PasswordResetService;
use App\Services\VerificationService;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\OrganizerController;
use App\Controllers\PasswordResetController;
use App\Controllers\AttendeeController;
use App\Controllers\EventController;
use App\Controllers\EventImageController;
use App\Controllers\TicketTypeController;
use App\Controllers\OrderController;
use App\Controllers\TicketController;
use App\Controllers\ScannerController;
use App\Controllers\PosController;
use App\Controllers\AwardController;
use App\Controllers\AwardCategoryController;
use App\Controllers\AwardNomineeController;
use App\Controllers\AwardVoteController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RateLimitMiddleware;
use App\Middleware\JsonBodyParserMiddleware;

return function ($container) {
    
    // ==================== SERVICES ====================
    
    $container->set(EmailService::class, function () {
        return new EmailService();
    });

    $container->set(SMSService::class, function () {
        return new SMSService();
    });
    
    $container->set(AuthService::class, function () {
        return new AuthService();
    });
    
    $container->set(PasswordResetService::class, function ($container) {
        return new PasswordResetService($container->get(EmailService::class));
    });
    
    $container->set(VerificationService::class, function ($container) {
        return new VerificationService($container->get(EmailService::class));
    });

    // Generic Infrastructure Services
    $container->set(\App\Services\ActivityLogService::class, function () {
        return new \App\Services\ActivityLogService();
    });

    $container->set(\App\Services\UploadService::class, function () {
        return new \App\Services\UploadService();
    });

    $container->set(\App\Services\NotificationService::class, function ($container) {
        return new \App\Services\NotificationService(
            $container->get(EmailService::class),
            $container->get(SMSService::class),
            $container->get(\App\Services\NotificationQueue::class),
            $container->get(\App\Services\TemplateEngine::class)
        );
    });

    $container->set(\Psr\Http\Message\ResponseFactoryInterface::class, function () {
        return new \Slim\Psr7\Factory\ResponseFactory();
    });
    
    // ==================== CONTROLLERS ====================
    
    $container->set(AuthController::class, function ($container) {
        return new AuthController(
            $container->get(AuthService::class),
            $container->get(\App\Services\ActivityLogService::class)
        );
    });
    
    $container->set(UserController::class, function ($container) {
        return new UserController($container->get(\App\Services\ActivityLogService::class));
    });

    
    $container->set(PasswordResetController::class, function ($container) {
        return new PasswordResetController(
            $container->get(AuthService::class),
            $container->get(EmailService::class)
        );
    });

   
    
    // ==================== MIDDLEWARES ====================
    
    $container->set(AuthMiddleware::class, function ($container) {
        return new AuthMiddleware($container->get(AuthService::class));
    });
    
    $container->set(RateLimitMiddleware::class, function () {
        return new RateLimitMiddleware();
    });
    
    $container->set(JsonBodyParserMiddleware::class, function () {
        return new JsonBodyParserMiddleware();
    });

    
    return $container;
};
