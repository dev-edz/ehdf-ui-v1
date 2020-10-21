<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HDFController extends Controller
{
    public function getPersons(){
        $persons = DB::select('select * from tblhperson', [1]);
        return $persons;
    }

    public function getTransactions(){
        $transactions = DB::table('tblhtransaction')
                    ->leftJoin('tbluserinfo', 'tblhtransaction.UserInfoID', '=', 'tbluserinfo.USERINFOID')
                    ->leftJoin('tblhperson', 'tblhtransaction.PersonID', '=', 'tblhperson.Id')
                    ->leftJoin('libcombinedoffices', 'tblhtransaction.Employer', '=', 'libcombinedoffices.Id')
                    ->select(
                        'tblhtransaction.Id', 
                        'tblhtransaction.PersonID', 
                        'tblhtransaction.UserInfoID', 
                        'tbluserinfo.USERFULLNAME', 
                        'libcombinedoffices.Office', 
                        'tblhtransaction.OfficeVisit',
                        'tblhtransaction.DateCreated',
                        'tblhperson.FirstName',
                        'tblhperson.MiddleName',
                        'tblhperson.LastName',
                        'tblhperson.SuffixName'
                    )
                    ->orderBy('tblhtransaction.DateCreated', 'desc')
                    ->get();
                    
                    
                
        // $transactions = DB::table('tblhperson')
        //     ->join(
        //             'tblhtransaction', 
        //             'tblhtransaction.PersonID', '=', 'tblhperson.Id'
        //         )
        //     // ->leftjoin(
        //     //         'libcombinedoffices', 
        //     //         'libcombinedoffices.Id', '=', 'tblhtransaction.OfficeVisit'
        //     //     )
        //     ->join(
        //             'tbluserinfo', 
        //             'tblhtransaction.UserInfoID', '=', 'tbluserinfo.userinfoid'
        //         )
        //     ->select(
        //             'tblhtransaction.Id', 
        //             DB::raw("CONCAT (
        //                 tblhperson.FirstName,' ',tblhperson.MiddleName,' ',tblhperson.LastName,' ',tblhperson.SuffixName) As FullName"), 
        //             'tblhtransaction.DateCreated',
        //             'tbluserinfo.userfullname'
        //             // 'libcombinedoffices.Office',
        //         )
        //     ->get();
        return $transactions;
    }
}
