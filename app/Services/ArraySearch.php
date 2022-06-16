<?php

namespace App\Services;

use App\Services\TimeCounter;
use \Exception;

class ArraySearch
{
    /**
     * Generate index for array. The keys of index are hundrids of value of sourse array, the value of index contents keys of source array;
     *
     * @param array $array
     * @return array
     */
    public static function createIndex(array $array): array
    {
        $indexArray = [];
        foreach($array as $key => $item) {
            $index = ceil($item / 100);
            $indexArray[$index] = $key;
        }
        return $indexArray;
    }

    /**
     * Base function for search
     *
     * @param mixed needle
     * @param array array
     * @param string method
     *
     * @return mixed
     */
    public static function search(mixed $needle, array $array, string $method): mixed
    {
 
        if(count($array) == 0) {
            $result = [
                'array' => $array,
                'duration' => 0,
                'message' => 'Array is empty!'
            ];
        } else {
            $time = new TimeCounter();
            $time->start();
   
            switch ($method) {
                case 'linear':
                    $result = [
                        'method' => 'Linear search',
                        'key' => self::linearSearch($needle, $array),
                    ];
                    break;
                case 'binary':
                    $result = [
                        'method' => 'Binary search',
                        'key' => self::binarySearch($needle, $array),
                    ];
                    break;
                case 'index':
                    $result = [
                        'method' => 'Index search',
                        'key' => self::indexSearch($needle, $array['value'], $array['index']),
                    ];
                    break;
                default:
                    throw new Exception('Method not found!');
                    break;
            }

            $time->finish();
            $result = array_merge($result, [
                'value' => $needle,
                'message' => ($result['key'] == '-1') ? 'Value not found' : '',
                'duration' => $time->duration,
            ]);
        }
        return $result;
    }

    /**
     * Linear search. Return first key of found element or -1 if element not found
     *
     * @param mixed $needle
     * @param array $array
     * @return array
     */
    public static function linearSearch(mixed $needle, array $array): string
    {
        $resultKey = '-1';
        foreach($array as $key => $item)
        {
            if ($item == $needle) {
                $resultKey = $key;
                break;
            }
        }
        return $resultKey;           
    }

    /**
     * Binary search. Return first key of found element or -1 if element not found
     *
     * @param mixed $needle
     * @param array $array
     * @return array
     */
    public static function binarySearch(mixed $needle, array $array): string
    {
        $resultKey = '-1';
        
        $minIndex = 0;
        $maxIndex = count($array) - 1;

        if (($needle >= $array[$minIndex]) && ($needle <= $array[$maxIndex])) {
            while($minIndex <= $maxIndex) {
                $midIndex = (int)(($minIndex + $maxIndex) / 2);
                if ($array[$midIndex] < $needle) {
                    $minIndex = $midIndex + 1;
                } else if ($array[$midIndex] > $needle) {
                    $maxIndex = $midIndex - 1;
                } else {
                    return $midIndex;
                }
            }
        }
        return $resultKey;           
    }

    /**
     * Indexed search. Return first key of found element or -1 if element not found
     *
     * @param mixed $needle
     * @param array $array
     * @param array $indexArray
     * @return array
     */
    public static function indexSearch(mixed $needle, array $array, array $indexArray): string
    {
        $resultKey = '-1';

        $keyBegin = $indexArray[floor($needle / 100)];
        $keyEnd = $indexArray[ceil($needle / 100)];

        for($i = $keyBegin; $i<=$keyEnd; $i++) {
            if($array[$i] == $needle) {
                $resultKey = $i;
                break;
            }
        }        
        return $resultKey;           
    }

}
