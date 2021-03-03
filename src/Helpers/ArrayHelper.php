<?php
namespace Kl\Helpers;

/**
 * Class ArrayHelper
 * @package Kl\Helpers
 */
class ArrayHelper
{
    /**
     * @param array $data
     * @param string $conversionRule
     * @return array
     */
    public static function toArray(array $data, string $conversionRule = 'underscore'):array
    {
        $result = [];

        switch ($conversionRule) {
            case 'camelCase':
                foreach ($data as $field => $value) {
                    $newField = self::trimString($field);
                    $newField = lcfirst($newField);

                    $result[$newField] = $value;
                }
                break;
            case 'underscore':
                foreach ($data as $field => $value) {
                    $newField = self::trimString($field);
                    $result[$newField] = $value;
                }
                break;
        }

        return $result;
    }

    public static function trimString(string $data):string
    {
        $data = preg_replace('/[^a-z0-9]+/i', ' ', $data);
        $data = trim($data);
        $data = ucwords($data);
        return str_replace(' ', '', $data);
    }
}