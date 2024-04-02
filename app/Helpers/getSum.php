<?php

function getSum($table,$column,$qrr_id)
{
    $sum = DB::table($table)->where('qrr_id',$qrr_id)->sum($column);
    //dd($sum);
    return $sum;
}

function CompanyName($id)
{
    $companyname=DB::table('users')->where('id', $id)->select('name')->first();

      return $companyname->name;

}
