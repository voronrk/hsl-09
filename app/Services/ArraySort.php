<?php

namespace App\Services;

use App\Services\TimeCounter;
use \Exception;

class ArraySort
{

    /**
     * This function change value of two integer variables.
     * !WARNING! Don't use this method for float variables because you can get a rounding error!
     *
     * @param int $a
     * @param int $b
     * @return void
     */
    public static function swapIntElements(int &$a, int &$b)
    {
        $a = $a + $b;
        $b = $a - $b;
        $a = $a - $b;
        return true;
    }

    /**
     * Insert element to $key position to array
     *
     * @param array $array
     * @param integer $key
     * @param mixed $insertedElement
     * @return void
     */
    public static function insertElement(array &$array, int $key, mixed $insertedElement)
    {
        array_splice($array, $key, 0, $insertedElement);
        return true;
    }
        
    /**
     * Base function for sorting
     *
     * @param array array
     * @param string method
     *
     * @return array
     */
    public static function sort(array $array, string $method): array
    {
        $sortedArray = [];
 
        if(count($array) == 1) {
            $result = [
                'array' => $array,
                'duration' => 0,
                'message' => 'Array is too short for sorting!'
            ];
        } else {
            $time = new TimeCounter();
            $time->start();
   
            switch ($method) {
                case 'scalarBubble':
                    $sortedArray = self::sortingBubbleScalar($array);
                    $result['method'] = 'Bubble sorting';
                    break;
                case 'scalarInsertion':
                    $sortedArray = self::sortingInsertionScalar($array);
                    $result['method'] = 'Insertion sorting';
                    break;
                case 'scalarMerge':
                    $sortedArray = self::sortingMergeScalar($array);
                    $result['method'] = 'Merge sorting';
                    break;
                case 'scalarSelection':
                    $sortedArray = self::sortingSelectionScalar($array);
                    $result['method'] = 'Selection sorting';
                    break;
                case 'scalarQuick':
                    $sortedArray = self::sortingQuickScalar($array);
                    $result['method'] = 'Quick sorting';
                    break;
                default:
                    throw new Exception('Method not found!');
                    break;
            }

            $time->finish();
            $result = array_merge($result, [
                'array' => $sortedArray,
                'duration' => $time->duration,
            ]);
        }
        return $result;
    }

    /**
     * Bubble sorting. Return sorted array by bubble method.
     *
     * @param array $array
     * @return array
     */
    public static function sortingBubbleScalar(array $array): array
    {
        for($finishElementIndex = count($array); $finishElementIndex > 0; $finishElementIndex--)
        {
            for($i=0; $i < $finishElementIndex-1; $i++) 
            {
                if ($array[$i] > $array[$i+1]) {
                    self::swapIntElements($array[$i], $array[$i+1]);
                }
            }
        } 
        return $array;           
    }

    /**
     * Insertion sorting. Return sorted array by insertion method.
     *
     * @param array $array
     * @return array
     */
    public static function sortingInsertionScalar(array $array): array
    {
        $sortedArray = [$array[0]];

        for($i = 1; $i < count($array); $i++) {
            $currentElement = $array[$i];
            $s = -1;
            do {
                $s++;
            } while(($s < count($sortedArray)) && ($currentElement > $sortedArray[$s]));

            if ($s == count($sortedArray) && ($currentElement > $sortedArray[$s-1])) {
                $sortedArray[] = $currentElement;
            } else {
                self::insertElement($sortedArray, $s, $currentElement);
            }            
        }
        return $sortedArray;           
    }

    /**
     * Merge sorting. Return sorted array by merge method.
     *
     * @param array $array
     * @return array
     */
    public static function sortingMergeScalar(array $array): array
    {
        $sizeOfArray = count($array);
        if ($sizeOfArray == 1) {
            $sortedArray = $array;
        } else {
            $leftPart = array_slice($array, 0, (int)($sizeOfArray / 2));
            $rightPart = array_slice($array, (int)($sizeOfArray / 2));

            $leftPart = self::sortingMergeScalar($leftPart);
            $rightPart = self::sortingMergeScalar($rightPart);
            $sortedArray = self::mergeForSortingMergeScalar($leftPart, $rightPart);
        }
        return $sortedArray;
    }

    /**
     * Service method for merge sorting. Merge two array by accept.
     *
     * @param array $leftPart
     * @param array $rightPart
     * @return array
     */
    private static function mergeForSortingMergeScalar(array $leftPart, array $rightPart): array
    {
        $result = [];
        while ((count($leftPart) > 0) && (count($rightPart) > 0)) {
            if ($leftPart[0] < $rightPart[0]) {
                array_push($result, array_shift($leftPart));
            } else {
                array_push($result, array_shift($rightPart));
            }
        }
        array_splice($result, count($result), 0, $leftPart);
        array_splice($result, count($result), 0, $rightPart);
        return $result;
    }

    /**
     * Selection sorter. Return sorted array by selection method.
     *
     * @param array $array
     * @return array
     */
    public static function sortingSelectionScalar(array $array): array
    {
        for($arrayIndex = 0; $arrayIndex < count($array); $arrayIndex++) {
            $lastHeadElementIndex = $arrayIndex;
            $tailMinElementIndex = $arrayIndex;
            for($tailIndex = $arrayIndex; $tailIndex < count($array); $tailIndex++) {
                if($array[$tailIndex] < $array[$tailMinElementIndex]) {
                    $tailMinElementIndex = $tailIndex;
                }
            }
            if ($tailMinElementIndex != $lastHeadElementIndex) {
                self::swapIntElements($array[$tailMinElementIndex], $array[$lastHeadElementIndex]);
            }
        }
        return $array;
    }

    /**
     * Quick sorting. Return sorted array by quick method.
     *
     * @param array $array
     * @return array
     */
    public static function sortingQuickScalar(array $array): array
    {
        $sizeOfArray = count($array);
        if ($sizeOfArray <= 1) {
            return $array;
        } else {
            $pivot = $array[0];
            $left_part = [];
            $right_part = [];
        
            for ($i = 1; $i < $sizeOfArray; $i++) {
                if ($array[$i] <= $pivot) {
                    $left_part[] = $array[$i];
                } else {
                    $right_part[] = $array[$i];
                }
            }
        
            $left_part = self::sortingQuickScalar($left_part);
            $right_part = self::sortingQuickScalar($right_part);
        
            return array_merge($left_part, array($pivot), $right_part);
        }   
    }
}
