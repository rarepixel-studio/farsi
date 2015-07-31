<?php
namespace Opilo\Farsi;

class MiscHelpers
{
    /**
     * Iterative binary search
     *
     * @param int $x The target integer to search
     * @param array $list The sorted array
     * @return int The index of the search key if found, otherwise the place to insert the search key
     */
    public static function binarySearch($x, $list) {
        $left = 0;
        $right = count($list) - 1;

        while ($left <= $right) {
            $mid = (int)(($left + $right)/2);

            if ($list[$mid] == $x) {
                return $mid;
            } elseif ($list[$mid] < $x) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }

        return $left;
    }

}