<?php

function getMaxID($table)
{
    $maxid = DB::table($table)->max('id');
    if(!$maxid)
    {
        $maxid = 1;
    }

    return $maxid;
}

