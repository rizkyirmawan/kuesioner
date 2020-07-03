<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::segment(2) === 'mahasiswa') {
            switch ($this->method()) {
                case 'POST':
                    return [
                        'email' => 'required|email|unique:users,email'
                    ];
                    break;
                case 'PATCH':
                    return [
                        'email' => 'required|email|unique:users,email,' . $this->mahasiswa->user->id
                    ];
                    break;
                default:
                    break;
            }
        } elseif (Request::segment(2) === 'dosen') {
            switch ($this->method()) {
                case 'POST':
                    return [
                        'email' => 'required|email|unique:users,email'
                    ];
                    break;
                case 'PATCH':
                    return [
                        'email' => 'required|email|unique:users,email,' . $this->dosen->user->id
                    ];
                    break;
                default:
                    break;
            }
        }
    }

    public function messages()
    {
        return [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Silahkan isi dengan email yang valid.',
            'email.unique' => 'Email sudah terdaftar.'
        ];
    }
}
