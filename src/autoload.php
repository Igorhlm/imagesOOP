<?php

spl_autoload_register(function ($className) {
    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    $incName = __DIR__.DIRECTORY_SEPARATOR.$fileName . '.php';;

    include $incName;
});