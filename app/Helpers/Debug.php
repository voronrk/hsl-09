<?php

namespace Helpers;

class Debug
{
    function show($data) 
    {
        echo "<pre>";
        echo (print_r($data, true) . PHP_EOL);
        echo "</pre>";
    }
}

