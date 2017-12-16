<?php

function create($class, $attributes = [], $quantity = 1)
{
    $class = "Pawer\Models\\" . $class;
    if($quantity === 1) return factory($class)->create($attributes);
    return factory($class, $quantity)->create($attributes);
}

function make($class, $attributes = [], $quantity = 1)
{
    $class = "Pawer\Models\\" . $class;
    if($quantity === 1) return factory($class)->make($attributes);
    return factory($class, $quantity)->make($attributes);
}