<?php

/**
 *
 * @author KoolPHP Inc.
 */

interface GridIValueMap
{
    function mapValue($value, $column);
    function inverseMapValue($value, $column);
}

class IdentityMap implements GridIValueMap
{
    function mapValue($value, $column)
    {
        return $value;
    }
    
    function inverseMapValue($value, $column)
    {
        return $value;
    }   
}

class ReverseMap implements GridIValueMap
{
    function mapValue($value, $column)
    {
        if ($column == "comments")
            $value = strrev($value);
        return $value;
    }
    
    function inverseMapValue($value, $column)
    {
        if ($column == "comments")
            $value = strrev($value);
        return $value;
    }    
}

class HtmlDecodeMap implements GridIValueMap
{
    function mapValue($value, $column)
    {
        if (is_string($value))
            $value = html_entity_decode($value);
        return $value;
    }
    
    function inverseMapValue($value, $column)
    {
        return $value;
    }       
}