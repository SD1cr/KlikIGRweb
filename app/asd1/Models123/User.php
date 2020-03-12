<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $table = 'members';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static function getUserAddress()
    {
        $useradd = Auth::Address()->member_id();
            return User::Distinct()
                ->Where('id', $useradd)
                ->Get();

    }

    public static function getProfileUser()
    {
        $userid = \Auth::User()->id;
        return User::Distinct()
            ->Join('addresses', 'members.id', '=', 'addresses.member_id')
            ->Where('members.id', $userid)
            ->Where('flag_default', 1)
            ->Get();

    } 

    public static function getAllUsers($cab = "%", $type ="%")   
    {   
 
        $result = User::Distinct()
            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'type', 'sub_districts.sub_district_name', 'npwp_name', 'npwp_address', 'npwp_number', 'kodemember')
            ->join('addresses', 'addresses.member_id', '=', 'members.id')
            ->join('types', 'members.type_id','=','types.id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id');
        if(\Auth::user('users_admin')->role == 2) {
            $result ->Where('kode_igr', \Auth::user('users_admin')->branch_code);
        }else {
            $result ->Where('kode_igr', 'LIKE', $cab);
        }   
        $result = $result
//            ->Where('flag_default', 1)
            ->Where('type_id', 'LIKE', $type)
            ->get();

        return $result;
    }

    public static function getNameMember(){ 
        $userid = \Auth::User()->id;
        return User::Distinct()
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kode_member, nama, npwp_name, npwp_number, npwp_address, email')
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->Where('members.id', $userid)
            ->get();
    }

}
