<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';

    public static function getBranches(){  
        $userid = \Auth::User()->id;
        return Branch::Distinct()   
            ->Join('addresses', 'branches.id', '=', 'branch_id')
            ->Where('member_id', $userid)
            ->Where('flag_default', 1)
            ->Pluck('kode_igr');
    }

    public static function getBranchByDistrict($prov = "%")
    {
        return \DB::Table('cities')->Distinct()
            ->Where('province_id', "LIKE", "%" . $prov . "%")
            ->OrderBy('city_code')
            ->Get();
    }

    public static function getAllBranches(){
        return Branch::Distinct()->Where('kode_igr','<>', '00')->OrderBy('kode_igr')->get();
    }

    public static function getAllFirstBranches($cab = "%"){
        if(\Auth::user('users_admin')->role == 2){
            return Branch::Distinct()->Where('kode_igr',\Auth::user('users_admin')->branch_code)->Pluck('name');
        }else{
            return Branch::Distinct()->Where('kode_igr', 'LIKE', $cab)->Pluck('name');
        }

    }

    public static function getCartBranches($id){
        $userid = \Auth::User()->id;
        return Branch::Distinct()
            ->Join('addresses', 'branches.id', '=', 'branch_id')
            ->Where('member_id', $userid)
            ->Where('addresses.id', $id)
            ->Pluck('kode_igr');
    }

    public static function getBranchesName(){
        $userid = \Auth::User()->id;
        return Branch::Distinct()
            ->Join('addresses', 'branches.id', '=', 'branch_id')
            ->Where('member_id', $userid)
            ->Where('flag_default', 1)
            ->Pluck('name');
    }

}
