<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Helpers\Debug;
use App\Http\Services\ArraySort;

class SortTest extends Controller
{
    function sortTest(array $array) {

        $result = [];

        $methods = [
            'scalarBubble',
            'scalarInsertion',
            'scalarMerge',
            'scalarSelection',
            'scalarQuick',
        ];
        
        foreach($methods as $method) {
            try {
                $result[] = ArraySort::sort($array, $method);
            } catch (Exception $e) {
                $result[] = $e->getMessage();
            }
        }
        return $result;
    }
}