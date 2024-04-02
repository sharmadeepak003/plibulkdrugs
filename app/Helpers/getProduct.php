<?php

function getProduct($id)
{
    $prod = DB::table('eligible_products')->where('id',$id)->first();

    return $prod;
}

function getCurrentQuarterValue($month)
{
    switch ($month)
    {
        case '1':
        case '2':
        case '3':
            return 4;
        case '4':
        case '5':
        case '6':
            return 1;
        case '7':
        case '8':
        case '9':
            return 2;
        case '10':
        case '11':
        case '12':
            return 3;
        default:
            return "Invalid option";
    }
}

