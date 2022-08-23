<?php

namespace payuru\phpPayu4;

class Std
{
    public static function removeNullValues($array) {
        foreach ($array as $key => $entry) {
            if (is_array($entry)) {
                $array[$key] = self::removeNullValues($entry);
                if ($array[$key] === []) {
                    unset($array[$key]);
                }
            } else {
                if ($entry === null) {
                    unset($array[$key]);
                }
            }
        }

        return $array;
    }
}