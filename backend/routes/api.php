<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\SiteController;
use App\Http\Controllers\Api\V1\BackupController;
use App\Http\Controllers\Api\V1\SecurityController;
use App\Http\Controllers\Api\V1\UpdateController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AnalyticsController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SubscriptionController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        
        // Client management
        Route::apiResource('clients', ClientController::class);
        
        // Site management
        Route::apiResource('sites', SiteController::class);
        Route::post('/sites/{id}/check', [SiteController::class, 'checkStatus']);
        
        // Backup management
        Route::apiResource('backups', BackupController::class);
        Route::post('/backups/{id}/restore', [BackupController::class, 'restore']);
        Route::post('/backups/{id}/download', [BackupController::class, 'download']);
        
        // Security
        Route::get('/security/scans', [SecurityController::class, 'index']);
        Route::post('/security/scan/{siteId}', [SecurityController::class, 'scan']);
        Route::get('/security/scans/{id}', [SecurityController::class, 'show']);
        
        // Updates
        Route::apiResource('updates', UpdateController::class);
        Route::post('/updates/{id}/apply', [UpdateController::class, 'apply']);
        Route::post('/updates/{id}/schedule', [UpdateController::class, 'schedule']);
        
        // Reports
        Route::apiResource('reports', ReportController::class);
        Route::post('/reports/generate', [ReportController::class, 'generate']);
        Route::get('/reports/{id}/download', [ReportController::class, 'download']);
        
        // Support tickets
        Route::apiResource('tickets', TicketController::class);
        Route::post('/tickets/{id}/assign', [TicketController::class, 'assign']);
        Route::post('/tickets/{id}/resolve', [TicketController::class, 'resolve']);
        
        // Analytics
        Route::get('/analytics/overview', [AnalyticsController::class, 'overview']);
        Route::get('/analytics/performance', [AnalyticsController::class, 'performance']);
        Route::get('/analytics/security', [AnalyticsController::class, 'security']);
        Route::get('/analytics/sites/{id}', [AnalyticsController::class, 'siteAnalytics']);
        
        // User management
        Route::apiResource('users', UserController::class);
        
        // Subscription management
        Route::apiResource('subscriptions', SubscriptionController::class);
        Route::post('/subscriptions/{id}/cancel', [SubscriptionController::class, 'cancel']);
        Route::post('/subscriptions/{id}/resume', [SubscriptionController::class, 'resume']);
    });
    
    // WordPress plugin endpoints (authenticated via API key)
    Route::prefix('wp')->group(function () {
        Route::post('/monitor', [SiteController::class, 'receiveMonitorData']);
        Route::post('/daily-report', [SiteController::class, 'receiveDailyReport']);
    });
});
