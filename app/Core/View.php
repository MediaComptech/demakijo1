<?php

namespace App\Core;

use eftec\bladeone\BladeOne;

/**
 * Kelas View
 * 
 * Wrapper untuk Template Engine BladeOne.
 */
class View
{
    private static $blade;

    /**
     * Inisialisasi BladeOne
     */
    public static function init()
    {
        $viewsPath = __DIR__ . '/../Views';
        $cachePath = __DIR__ . '/../../storage/cache';

        // Buat folder cache jika belum ada
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        // Mode pengembangan: MODE_DEBUG, Mode produksi: MODE_AUTO
        $mode = ($_ENV['APP_ENV'] ?? 'local') === 'production' ? BladeOne::MODE_AUTO : BladeOne::MODE_DEBUG;

        self::$blade = new BladeOne($viewsPath, $cachePath, $mode);
    }

    /**
     * Render template
     * 
     * @param string $view Nama file view (contoh: 'home.index')
     * @param array $data Data untuk dikirim ke view
     */
    public static function render($view, $data = [])
    {
        try {
            echo self::$blade->run($view, $data);
        } catch (\Exception $e) {
            echo "Error rendering view [{$view}]: " . $e->getMessage();
        }
    }
}
