<?php

namespace App\Services;

class ArrayGenerate
{
    static function intArray(int $size): array
    {   
        $resultArray = [];
        for($i=0; $i<$size; $i++)
        {
            $resultArray[$i] = rand(-1000, 1000);
        };
        return $resultArray;
    }
}

