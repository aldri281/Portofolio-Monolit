<?php

// Suppress deprecated notices from vendor/framework files in production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require __DIR__ . '/../public/index.php';
