<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\PhoneNumber;
use App\Rules\BirthDayShouldBe;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphabetAndUnderLineCharactersOnly;
use Illuminate\Http\Request;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'email' => "required|email|unique:App\Models\User,email,{$this->id}",
            'username' => ['required', 'string', 'max:25', Rule::unique('App\Models\User')->ignore($this->id), new AlphabetAndUnderLineCharactersOnly],
            'password' => 'nullable|confirmed|min:8',
            'name' => 'required|string|max:50|min:3',
            'mobile' => ["unique:App\Models\User,mobile,{$this->id}", new PhoneNumber],
            'dateOfBirth' => ['required', 'string', new BirthDayShouldBe],
            'roles' => 'required',
            'cabor' => 'required_if:roles,Organisasi/Cabor',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'cabor.required_if' => ':attribute can not be empty.',
        ];
    }
}
