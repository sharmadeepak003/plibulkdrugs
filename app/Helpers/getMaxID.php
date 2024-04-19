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


function get_target_segment() {

    $target_segment=DB::table('eligible_products')->distinct('target_segment')->select('target_segment','id')->get();

    $arr_target_segment=array();

    foreach($target_segment as $ts_value)
    {
        if($ts_value->id!='' and $ts_value->target_segment!='')
        {
            $arr_target_segment[$ts_value->id]=$ts_value->target_segment;
        }
    }
    return $arr_target_segment;
} 

