<?php

$replacements = [
    'TempletSDKPHP' => 'НОВИЙ_ТЕКСТ_1',
];


$rootDir    = realpath(__DIR__ . "/../");
$scriptDir  = realpath(__DIR__); 
$ignoreDirs = ['vendor', 'node_modules'];

$extensions = ['php', 'txt', 'html', 'json'];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootDir, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }

    $filePath = realpath($file->getPath());

    // Пропустити директорію скрипта
    if (strpos($filePath, $scriptDir) === 0) {
        continue;
    }
    
    foreach ($ignoreDirs as $dir) {
        if (strpos($filePath, DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR) !== false) {
            continue 2; // пропустити цей файл
        }
    }

//    $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
//    if (!empty($extensions) && !in_array($ext, $extensions, true)) {
//        continue;
//    }

    $path = $file->getPathname();
    $content = file_get_contents($path);
    if ($content === false) {
        continue;
    }

    $newContent = $content;

    // Заміна всіх текстів із масиву
    foreach ($replacements as $search => $replace) {
        $newContent = str_replace($search, $replace, $newContent);
    }

    // Записати файл тільки якщо зміни були
    if ($newContent !== $content) {
        file_put_contents($path, $newContent);
        echo "Оновлено: {$path}\n";
    }
}

echo "Готово.\n";
