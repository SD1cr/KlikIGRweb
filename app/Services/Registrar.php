<?php namespace App\Services;

use App\Models\User;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'Nama' => 'required|max:100',
			'Email' => 'required|email|max:50|unique:members',  
			'Password' => 'required|confirmed|min:6',
            'KodeMember' => 'required|unique:members',
            'KodeCabang' => 'required|digits:2',          
		]);
	}

	public function validateNewEmailList(array $data)
	{
		return Validator::make($data, [
			'Email' => 'required|email|max:50|unique:email_recipients',        
			'KodeCabang' => 'required|digits:2',
		]);
	}

	public function validateNewMember(array $data)
	{
		return Validator::make($data, [
			'Nama' => 'required|max:100',
			'Email' => 'required|email|max:50|unique:members',
			'Password' => 'required|confirmed|min:6',   
		]);
	}

	public function validateChPass(array $data)
	{
		return Validator::make($data, [
			//'KataSandiLama' => 'required|min:6',
			'KataSandiBaru' => 'required|confirmed|min:6',
		]);
	}


	public function validateNewPhones(array $data){
		return Validator::make($data, [
			'NoHp' => 'required|max:12',
		]);
	}


	public function validateNewAddress(array $data){
		return Validator::make($data, [
            'Alamat' => 'required|max:100',
            'Kota' => 'required|max:50',
            'KodePos' => 'required|max:7'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['Name'],
			'email' => $data['Email'],
			'password' => bcrypt($data['Password']),
            'kodemember' => $data['KodeMember'],
            'kode_cabang' => $data['KodeCabang'],
            'min_order' => $data['MinimalOrder'],
            'shipping_fee' => $data['ShippingFee'],
		]);
/*
		phones::create([
			'phone' => $data['NoHp']
		]);

		addresses::create([
			'address' => $data['Alamat'],
			'city' => $data['Kota'],
			'portal_code' => $data['KodePos']
			]);
*/
	}
}
