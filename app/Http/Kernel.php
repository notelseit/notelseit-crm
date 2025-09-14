protected $routeMiddleware = [
    // ...
    'admin.key' => \App\Http\Middleware\AdminKeyMiddleware::class,
];