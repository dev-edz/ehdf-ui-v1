<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HDFController extends Controller
{
    public function getPersons(){
        $persons = DB::select('select * from tblhperson', [1]);
        return $persons;
    }

    public function getNewPersons(){
        $date = \Carbon\Carbon::today();
        $newPersons = DB::table('tblhperson')
                ->select()
                ->where('DateCreated', '>=', $date)
                ->orderBy('DateCreated', 'asc')
                ->get();
        return $newPersons;
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
                        'tblhperson.SuffixName',
                        'tblhtransaction.Temperature',
                    )
                    ->orderBy('tblhtransaction.DateCreated', 'desc')
                    ->get();
                    
        return $transactions;
    }

    public function getRegisteredUserByDate(){
        $date = \Carbon\Carbon::today()->subDays(8);
        $registered_user = DB::table('tblhperson')
                ->select()
                ->where('DateCreated', '>=', $date)
                ->orderBy('DateCreated', 'asc')
                ->get()
                ->groupBy(function($item) {
                    return Carbon::parse($item->DateCreated)->format('M-d');
                });
        return $registered_user;
    }

    public function getAllTransactionByDate(){
        $date = \Carbon\Carbon::today();
        $transactions = DB::table('tblhtransaction')
                ->select()
                ->orderBy('DateCreated', 'asc')
                ->get()
                ->groupBy(function($item) {
                    return Carbon::parse($item->DateCreated)->format('M-d');
                });
        return $transactions;
    }

    public function getLatestPersons(){
        $date = \Carbon\Carbon::today();
        $newPersons = DB::table('tblhperson')
                ->select()
                ->where('DateCreated', '>=', $date)
                ->orderBy('DateCreated', 'asc')
                ->get()
                ->groupBy(function($item) {
                    // return Carbon::parse($item->DateCreated)->format('H:i');
                    return Carbon::parse($item->DateCreated)->format('H:i A');
                });
        return $newPersons;
    }

    public function getLatest(){
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
                        'tblhperson.SuffixName',
                        'tblhtransaction.Temperature',
                    )
                    ->orderBy('tblhtransaction.DateCreated', 'desc')
                    ->limit(1)->get();
                    
        return $transactions;
    }
}
