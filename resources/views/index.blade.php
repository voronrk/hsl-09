<?php

use App\Services\TimeCounter;
use App\Services\ArraySort;
use App\Services\ArraySearch;

function debug($data)
{
    echo "<pre>";
    echo (print_r($data, true) . PHP_EOL);
    echo "</pre>";
}

/**
 * Generate array of pseudo-random integer digits
 *
 * Size of Array
 * @param integer $size
 * @return array
 */
function generateDigitalArray(int $size): array
{   
    $resultArray = [];
    for($i=0; $i<$size; $i++)
    {
        $resultArray[$i] = rand(-1000, 1000);
    };
    return $resultArray;
}

/**
 * Test sorting methods
*/
function searchTest() {

    $array = generateDigitalArray(10);
    debug($array);

    $methods = [
        'scalarBubble',
        'scalarInsertion',
        'scalarMerge',
        'scalarSelection',
        'scalarQuick',
    ];
    
    foreach($methods as $method) {
        try {
            debug(ArraySort::sort($array, $method));
        } catch (Exception $e) {
            debug($e->getMessage());
        }
    }
}

/**
 * Test linear searching
*/
function linearSearchTest() {
    $array = generateDigitalArray(100);
    debug($array);

    $needle = 256;
    $needle = $array[34];

    try {
        debug(ArraySearch::search($needle, $array, 'linear'));
    } catch (Exception $e) {
        debug($e->getMessage());
    }
}

/**
 * Test linear searching
*/
function binarySearchTest() {

    $array = ArraySort::sort(generateDigitalArray(100), 'scalarBubble')['array'];
    debug($array);

    $needle = $array[93];
    // $needle = 256;

    try {        
        debug(ArraySearch::search($needle, $array, 'binary'));
    } catch (Exception $e) {
        debug($e->getMessage());
    }
}

function indexSearchTest() {
    $array['value'] = ArraySort::sort(generateDigitalArray(100), 'scalarBubble')['array'];
    $array['index'] = ArraySearch::createIndex($array['value']);
    debug($array);

    $needle = $array['value'][93];
    // $needle = 256;

    try {        
        debug(ArraySearch::search($needle, $array, 'index'));
    } catch (Exception $e) {
        debug($e->getMessage());
    }
}

// searchTest();

// linearSearchTest();
// binarySearchTest()
indexSearchTest();