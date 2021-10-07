<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:600000,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'get_user' => \App\Http\Middleware\MergeUserMiddlware::class,
        'get_website_user' => \App\Http\Middleware\MergeUserWebsiteMiddlware::class,
        'check_language' => \App\Http\Middleware\CheckLanguage::class,
        'check_admin' => \App\Http\Middleware\AdminMiddleware::class,
        'check_provider' => \App\Http\Middleware\ProviderMiddleware::class,
        'check_role' => \App\Http\Middleware\CheckRoleMiddleware::class,
        'check_maintenance_mode_app' => \App\Http\Middleware\MaintenanceMiddleware::class,
        'check_maintenance_mode_website' => \App\Http\Middleware\MaintenanceWebsiteMiddleware::class,


        'check_admin_lang' => \App\Http\Middleware\CheckAdminLang::class,
        'check_website_lang' => \App\Http\Middleware\CheckWebsiteLanguage::class,
        'check_country_code' => \App\Http\Middleware\CheckCountryWebsiteMiddleware::class,

        'merge_admin_fcm' => \App\Http\Middleware\MergeAdminFcmMiddleware::class,
        'published.product' => \App\Http\Middleware\PublishedProductsScope::class,
        'page-cache'=>\Silber\PageCache\Middleware\CacheResponse::class,
        'TokenInvalid'=> \App\Http\Middleware\TokenInvalid::class,

    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
