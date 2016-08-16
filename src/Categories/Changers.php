<?php

namespace SimpleArrayLibrary\Categories;

use InvalidArgumentException;
use UnexpectedValueException;

trait Changers
{
    /**
     * @param array $config
     * @param array $keys
     * @param mixed $value
     *
     * @return array
     */
    public static function addConfigRow(array $config, array $keys, $value)
    {
        // validation
        if (self::isAssociative($keys)) {
            throw new UnexpectedValueException('Array of config keys must be numeric');
        }

        $row = $value;
        for ($i = count($keys) - 1; $i >= 0; $i--) {
            $row = [$keys[$i] => $row];
        }
        $config = self::insertSubArray($config, $row);

        return $config;
    }

    /**
     * @param array $matrix
     * @param array $castMap
     * @param bool  $allKeysMustBePresent
     *
     * @return array
     */
    public static function castColumns(array $matrix, array $castMap, $allKeysMustBePresent = true)
    {
        if (!is_bool($allKeysMustBePresent)) {
            throw new InvalidArgumentException('Third parameter must be a boolean');
        }
        if (empty($matrix)) {
            return $matrix;
        }
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not cast columns on one dimensional array');
        }

        foreach ($matrix as $key => $row) {
            foreach ($castMap as $column => $type) {
                if (isset($row[$column]) || array_key_exists($column, $row)) {
                    switch ($type) {
                        case self::TYPE_INT:
                            $matrix[$key][$column] = (int)$row[$column];
                            break;
                        case self::TYPE_STRING:
                            $matrix[$key][$column] = (string)$row[$column];
                            break;
                        case self::TYPE_FLOAT:
                            $matrix[$key][$column] = (float)$row[$column];
                            break;
                        case self::TYPE_BOOL:
                            $matrix[$key][$column] = (bool)$row[$column];
                            break;
                        case self::TYPE_ARRAY:
                            $matrix[$key][$column] = (array)$row[$column];
                            break;
                        case self::TYPE_OBJECT:
                            $matrix[$key][$column] = (object)$row[$column];
                            break;
                        default:
                            throw new UnexpectedValueException('Invalid type: ' . $type);
                    }
                } elseif ($allKeysMustBePresent) {
                    throw new UnexpectedValueException('Column: ' . $column . ' missing in row: ' . $key);
                }
            }
        }

        return $matrix;
    }

    /**
     * @param array $matrix
     * @param mixed $columns
     *
     * @return array
     */
    public static function deleteColumns(array $matrix, array $columns)
    {
        // validate input
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not delete columns on one dimensional array');
        }
        if (self::countMinDepth($columns) != 1) {
            throw new InvalidArgumentException('Invalid column');
        }

        // remove columns in every row
        foreach ($matrix as $key => $row) {
            foreach ($columns as $column) {
                unset($matrix[$key][$column]);
            }
        }

        return $matrix;
    }

    /**
     * @param mixed $array
     * @param mixed $subArray
     * @param bool  $overwrite
     * @param bool  $ignoreIfExists
     *
     * @return array
     */
    public static function insertSubArray($array, $subArray, $overwrite = false, $ignoreIfExists = false)
    {
        // validate
        if (!is_bool($overwrite)) {
            throw new InvalidArgumentException('Overwrite indicator must be a boolean');
        }
        if (!is_bool($ignoreIfExists)) {
            throw new InvalidArgumentException('Ignore if exists indicator must be a boolean');
        }

        if (!is_array($subArray) || !is_array($array)) {
            // $subArray[$key] is leaf of the array
            if ($overwrite) {
                $array = $subArray;
            } elseif (!$ignoreIfExists) {
                throw new UnexpectedValueException('Sub-array already exists');
            }
        } else {
            $key = key($subArray);
            if (isset($array[$key]) || array_key_exists($key, $array)) {
                $array[$key] = self::insertSubArray($array[$key], $subArray[$key], $overwrite, $ignoreIfExists);
            } else {
                $array[$key] = $subArray[$key];
            }
        }

        return $array;
    }

    /**
     * @param array $matrix
     * @param mixed $column
     * @param mixed $value
     * @param bool  $insertIfMissing
     * @param bool  $overwrite
     *
     * @return array
     */
    public static function setColumn(array $matrix, $column, $value, $insertIfMissing = true, $overwrite = true)
    {
        // validate input
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not set columns on one dimensional array');
        }
        if (!is_scalar($column)) {
            throw new InvalidArgumentException('Invalid column');
        }
        if (!is_bool($insertIfMissing)) {
            throw new InvalidArgumentException('Insert if missing indicator must be a boolean');
        }
        if (!is_bool($overwrite)) {
            throw new InvalidArgumentException('Overwrite indicator must be a boolean');
        }

        foreach ($matrix as $key => $row) {
            if (isset($row[$column]) || array_key_exists($column, $row)) {
                $matrix[$key][$column] = ($overwrite ? $value : $matrix[$key][$column]);
            } elseif ($insertIfMissing) {
                $matrix[$key][$column] = $value;
            }
        }

        return $matrix;
    }
}