<?php

namespace App\Models;

use Carbon\Carbon;    
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public static function getBindingContract(){
        return Contract::whereIn('id', Address::find(Address::getDefaultAddressId())->contracts()->getRelatedIds())->get();
    }

    public static function getBindingContractIds(){
        return Address::find(Address::getDefaultAddressId())->contracts()->getRelatedIds();
    }

      public static function getCountItemContract(){
        $addr = Address::where('member_id', \Auth::user()->id)->where('flag_default', 1)->pluck('id');

        $countItemContract = \DB::table('contract_items')->distinct()
            ->join('contracts','contracts.id', '=', 'contract_items.contract_id')
            ->join('contract_addresses','contract_items.contract_id', '=', 'contract_addresses.contract_id')
            ->join('addresses','contract_addresses.address_id', '=', 'addresses.id')
            ->where('contracts.start_date', '<=', Carbon::today())
            ->where('contracts.end_date', '>=',Carbon::today())
            ->where('addresses.id', $addr)
            ->Count();
        return $countItemContract;

    }    

    public function addresses()
    {
        return $this->belongsToMany('App\Models\Address', 'contract_addresses', 'address_id', 'contract_id');
    }
}
