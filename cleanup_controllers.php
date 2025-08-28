<?php

/**
 * Script untuk merapikan controller API
 * Mengganti semua controller API untuk menggunakan BaseController
 */

$controllers = [
    'ActorController.php',
    'OrderController.php', 
    'PromoController.php',
    'SeatController.php',
    'StudioController.php'
];

$apiPath = 'app/Http/Controllers/Api/';

foreach ($controllers as $controller) {
    $filePath = $apiPath . $controller;
    
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Replace extends Controller with extends BaseController
        $content = str_replace(
            'class ' . str_replace('.php', '', $controller) . ' extends Controller',
            'class ' . str_replace('.php', '', $controller) . ' extends BaseController',
            $content
        );
        
        // Replace use Controller with use BaseController
        $content = str_replace(
            'use App\Http\Controllers\Controller;',
            'use App\Http\Controllers\Api\BaseController;',
            $content
        );
        
        // Add DB import if not exists
        if (strpos($content, 'use Illuminate\Support\Facades\DB;') === false) {
            $content = str_replace(
                'use Illuminate\Support\Facades\Storage;',
                "use Illuminate\Support\Facades\Storage;\nuse Illuminate\Support\Facades\DB;",
                $content
            );
        }
        
        // Replace old response methods
        $content = str_replace('$this->respondWithSuccess', '$this->success', $content);
        $content = str_replace('$this->respondWithError', '$this->error', $content);
        
        file_put_contents($filePath, $content);
        echo "Updated: $controller\n";
    }
}

echo "Controller cleanup completed!\n";
