<?php

namespace Illuminate\Support\Facades;

use App\Core\Session;
use Illuminate\Database\Capsule\Manager as Capsule;

class Storage
{
    public static function disk($name)
    {
        return new self();
    }

    public static function delete($path)
    {
        $fullPath = __DIR__ . '/../../../public/storage/' . $path;
        if (file_exists($fullPath)) {
            @unlink($fullPath);
            return true;
        }
        return false;
    }

    public static function put($path, $contents)
    {
        $fullPath = __DIR__ . '/../../../public/storage/' . $path;
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return file_put_contents($fullPath, $contents);
    }
}

class Cache
{
    public static function remember($key, $ttl, $callback)
    {
        // Dummy cache: always execute callback for now
        return $callback();
    }

    public static function forget($key)
    {
        // Dummy cache: do nothing
        return true;
    }
}

class Log
{
    public static function error($message, $context = [])
    {
        error_log("ERROR: " . $message . " " . json_encode($context));
    }

    public static function info($message, $context = [])
    {
        error_log("INFO: " . $message . " " . json_encode($context));
    }
}

class DB extends Capsule
{
    // Extends Capsule directly so DB::table(), DB::commit(), DB::rollBack() work
}

class File
{
    public static function exists($path)
    {
        return file_exists($path);
    }

    public static function delete($path)
    {
        if (file_exists($path)) {
            return @unlink($path);
        }
        return false;
    }
}
