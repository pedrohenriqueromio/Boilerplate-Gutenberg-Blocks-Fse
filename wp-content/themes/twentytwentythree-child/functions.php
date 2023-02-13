<?php

use DEV\Theme;

define( 'GUTENBERG_THEME_DIR', __DIR__ . '/general-blocks/' );

require_once __DIR__ . '/vendor/autoload.php';

$core = new DEV\Theme\Init();
