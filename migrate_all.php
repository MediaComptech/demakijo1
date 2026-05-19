<?php

$source_dir = 'C:/Users/SPV IT/Documents/Demakijo 1';
$dest_dir = 'C:/Users/SPV IT/Documents/demakijo1-konversi';

// Helper for copying directories recursively
function copy_dir($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0777, true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                copy_dir($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// 1. Copy Controllers
$src_controllers = $source_dir . '/app/Http/Controllers';
$dst_controllers = $dest_dir . '/app/Controllers';
copy_dir($src_controllers, $dst_controllers);

// Process Controllers to replace namespaces and logic
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dst_controllers));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Namespace replacement
        $content = str_replace('namespace App\Http\Controllers', 'namespace App\Controllers', $content);
        
        // Request object mapping
        $content = str_replace('use Illuminate\Http\Request;', "use App\Core\Request;\nuse App\Core\Auth;", $content);
        
        // Auth mapping
        $content = str_replace('Illuminate\Support\Facades\Auth', 'App\Core\Auth', $content);
        $content = str_replace('Auth::user()', '\App\Core\Auth::user()', $content);
        $content = str_replace('Auth::id()', '\App\Core\Session::get(\'user_id\')', $content);
        
        // Redirect route mapping (simple approach)
        $content = preg_replace('/redirect\(\)->route\((.*?)\)/', 'redirect($1)', $content);
        
        // View helper is already globally available and works with dots e.g., 'backend.siswa.index'

        file_put_contents($file->getPathname(), $content);
    }
}

// 2. Copy Views
$src_views = $source_dir . '/resources/views';
$dst_views = $dest_dir . '/app/Views';
copy_dir($src_views, $dst_views);

// Process Views
$view_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dst_views));
foreach ($view_iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        
        // Convert Laravel specific Blade directives
        $content = str_replace('@csrf', '{!! csrf_field() !!}', $content);
        $content = preg_replace('/@method\(\'(PUT|DELETE|PATCH)\'\)/', '<input type="hidden" name="_method" value="$1">', $content);
        $content = preg_replace('/route\(\s*\'(.*?)\'\s*\)/', 'url(\'$1\')', $content);
        
        file_put_contents($file->getPathname(), $content);
    }
}

// 3. Copy Routes
$src_routes = $source_dir . '/routes/web.php';
$dst_routes = $dest_dir . '/routes/web.php';
$routes_content = file_get_contents($src_routes);

// Replace Route::get with Router::get
$routes_content = str_replace('use Illuminate\Support\Facades\Route;', "use App\Core\Router;", $routes_content);
$routes_content = str_replace('Route::', 'Router::', $routes_content);
// Simplified conversion for Route groups (this will need manual checking, but automated as much as possible)
// Since we use native router, we'll append to existing routes for now
file_put_contents($dst_routes, file_get_contents($dest_dir . '/routes/web.php') . "\n// --- IMPORTED ROUTES ---\n" . $routes_content);

// 4. Copy Public Assets
$src_public = $source_dir . '/public';
$dst_public = $dest_dir . '/public';
// We only copy assets, build, images
@mkdir($dst_public . '/build', 0777, true);
if (is_dir($src_public . '/build')) {
    copy_dir($src_public . '/build', $dst_public . '/build');
}
if (is_dir($src_public . '/assets')) {
    copy_dir($src_public . '/assets', $dst_public . '/assets');
}

echo "Migrasi struktur, controller, view, dan public asset selesai!\n";
