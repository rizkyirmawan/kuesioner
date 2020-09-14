<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormulirPerusahaanRequest extends FormRequest
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
        return [
            'perusahaan' => 'required',
            'email_perusahaan' => 'required|email',
            'bidang' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'perusahaan.required' => 'Nama perusahaan tidak boleh kosong.',
            'email_perusahaan.required' => 'Email perusahaan tidak boleh kosong.',
            'email_perusahaan.email' => 'Email perusahaan tidak valid.',
            'bidang.required' => 'Silahkan pilih bidang perusahaan.'
        ];
    }
}
