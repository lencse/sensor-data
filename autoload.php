<?php

spl_autoload_register(function ($class) {
    require_once implode(
        DIRECTORY_SEPARATOR,
        [__DIR__, 'src', str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php']
    );
});
