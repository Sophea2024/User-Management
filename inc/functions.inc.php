<?php

function array_fill_columns(array $array, array $default) : array
{
    // $array = $visistors;
    // foreach ($array as $index => &$arrayElement) {
    foreach ($array as &$arrayElement) {
        $arrayElement = array_merge($default, $arrayElement);
    }
    unset($arrayElement);

    return $array;
}