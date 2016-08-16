<?php

namespace SimpleArrayLibrary\Categories;

use InvalidArgumentException;

trait Counters
{
    /**
     * Counts maximum array depth recursively
     *
     * @param array $array
     *
     * @return int
     */
    public static function countMaxDepth(array $array)
    {
        $maxDepth = 1;
        foreach ($array as $element) {
            $depth = 1;
            if (is_array($element)) {
                $depth += self::countMaxDepth($element);
            }
            if ($depth > $maxDepth) $maxDepth = $depth;
        }

        return $maxDepth;
    }

    /**
     * Counts maximum array depth iteratively
     *
     * @param array $array
     *
     * @return int
     */
    public static function countMaxDepthIterative(array $array)
    {
        $copy     = $array;
        $maxDepth = 1;

        foreach ($copy as $element) {
            $depth = 1;
            while (!empty($element)) {
                if (is_array($element)) {
                    ++$depth;
                    $tmp = array_shift($element);
                    if (is_array($tmp)) {
                        array_push($element, array_shift($tmp));
                    }
                } else {
                    break;
                }
            }
            if ($depth > $maxDepth) {
                $maxDepth = $depth;
            }
        }

        return $maxDepth;
    }

    /**
     * Counts maximum array depth
     *
     * @param mixed $potentialArray
     * @param int   $depth
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public static function countMinDepth($potentialArray, $depth = 0)
    {
        // validation, must be positive int or 0
        if (!self::isLogicallyCastableToInt($depth)) {
            throw new InvalidArgumentException('Depth parameter must be non-negative integer');
        }
        if ($depth < 0) {
            throw new InvalidArgumentException('Depth parameter must be non-negative integer');
        }

        $return = $depth;
        if (is_array($potentialArray)) {
            $return++;
            $childrenDepths = array();
            foreach ($potentialArray as $element) {
                $childrenDepths[] = self::countMinDepth($element, $return);
            }
            $return = empty($childrenDepths) ? $return : min($childrenDepths);
        }

        return $return;
    }
}