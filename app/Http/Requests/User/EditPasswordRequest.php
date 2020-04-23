<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditPasswordRequest extends FormRequest{

	public function authorize(){
		return true;
	}

	public function rules(){
		return [
			'password'	=> ['required', 'min:8', 'confirmed'],
		];
	}
}
