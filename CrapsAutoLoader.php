<?php

$folders = array('Common', 'Craps', 'Simulator');

spl_autoload_register(function ($class) use ($folders) {
    foreach ($folders as $folder)
    {
		$parts = explode('\\', $class);
        $filePath = __DIR__ . DIRECTORY_SEPARATOR  . 'src' . DIRECTORY_SEPARATOR . 'Game' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . end($parts) . '.php';
        if (file_exists($filePath))
        {
            include $filePath;
        }
    }
    
});

