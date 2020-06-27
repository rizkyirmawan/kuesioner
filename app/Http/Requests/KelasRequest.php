<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'kode' => 'required|unique:kelas,kode',
                    'kelas' => 'required'
                ];
                break;
            case 'PATCH':
                return [
                    'kode' => 'required|unique:kelas,kode,' . $this->id,
                    'kelas' => 'required'
                ];
                break;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode tidak boleh kosong.',
            'kode.unique' => 'Kode kelas sudah terdaftar.',
            'kelas.required' => 'Kelas tidak boleh kosong.'
        ];
    }
}
