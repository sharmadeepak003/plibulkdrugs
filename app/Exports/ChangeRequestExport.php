<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChangeRequestExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $change_type;

    function __construct($change_type) {
            $this->id = $change_type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->id == 'ALL'){
            $apps = DB::table('change_request_vw')->get();
        }elseif ($this->id == 'C') {
            $apps = DB::table('change_request_vw')->where('type_of_request','Corporate Address')->get();
        }elseif ($this->id == 'R') {
            $apps = DB::table('change_request_vw')->where('type_of_request','Registered Address')->get();
        } elseif ($this->id == 'A') {
            $apps = DB::table('change_request_vw')->where('type_of_request','Authorised Signatory')->get();
        }   
        return $apps;
    }

    public function headings(): array
    {
        return [
            'Applicant Name',
            'Change_type',
            'Status',
            'Date'
        ];
    }
}
