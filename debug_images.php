<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$images = App\Models\ProjectImage::all();
foreach ($images as $img) {
    echo "ID: {$img->id}, Project: {$img->project_id}, URL: {$img->image_url}\n";
}
