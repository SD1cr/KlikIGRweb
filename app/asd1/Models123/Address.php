<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    public static function getAddress(){
        $userid = \Auth::User()->id;
        return Address::Distinct()
            ->Where('member_id', $userid)
            ->Where('flag_default', 1)
            ->Get();
    }

    public static function getAddressID(){
        $userid = \Auth::User()->id;
        return Address::Distinct()
            ->Where('member_id', $userid)
            ->Where('flag_default', 1)
            ->Pluck('id'); 
    }
	
	public static function getAddresses(){      
    if (!\Auth::guest()) {
        $typeuserid = \Auth::User()->type_id;
    }else{
        $typeuserid = '3';
    }
    $userid = \Auth::User()->id;
    $var =  Address::Distinct()
        ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
        ->join('branches','addresses.branch_id', '=', 'branches.id')
        ->join('provinces','addresses.province_id', '=', 'provinces.id')
        ->join('cities', 'addresses.city_id','=','cities.id')
        ->join('members', 'addresses.member_id', '=', 'members.id')
        ->join('districts', 'addresses.district_id', '=', 'districts.id')
        ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id');
        if($typeuserid != 1) {
            $var->Where('flag_default', 1);
        }
            $var = $var->where('members.id', $userid)
        ->get();

    return $var;

}

    public static function getAddressCheckout(){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }
        $userid = \Auth::User()->id;
        $var =  Address::Distinct()
            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('members', 'addresses.member_id', '=', 'members.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
            ->where('members.id', $userid)
            ->Where('flag_default', 1)->get();

        return $var;

    }

    public static function getOptAddress(){
        $userid = \Auth::User()->id;
        $var =  Address::Distinct()
            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('members', 'addresses.member_id', '=', 'members.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
            ->Where('flag_default', '<>',1)
            ->where('members.id', $userid)
            ->get();
        return $var;

    }


    public static function getDefaultAddress(){
        $addr = Address::select('address')->where('member_id', \Auth::user()->id)->where('flag_default', 1)->first();   

        if($addr!= null){
            return $addr->address;
        }else{
            return "";
        }

    }
    public static function getDefaultAddressId(){
        $addr = Address::select('id')->where('member_id', \Auth::user()->id)->where('flag_default', 1)->first();

        if($addr!= null){
            return $addr->id;
        }else{
            return "";
        }
    }

    public function contracts()
    {
        return $this->belongsToMany('App\Models\Contract', 'contract_addresses', 'address_id', 'contract_id')
                    ->where('contracts.start_date', '<=', Carbon::today())
                    ->where('contracts.end_date', '>=',Carbon::today());
    }
}
