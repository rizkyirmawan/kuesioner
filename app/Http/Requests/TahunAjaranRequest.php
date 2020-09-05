<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TahunAjaranRequest extends FormRequest
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
            'semester' => 'required',
            'tahun_ajaran' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'semester.required' => 'Semester tidak boleh kosong.',
            'tahun_ajaran' => 'Tahun ajaran tidak boleh kosong.'
        ];
    }
}
