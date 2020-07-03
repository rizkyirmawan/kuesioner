<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PertanyaanRequest extends FormRequest
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
            'pertanyaan' => 'required',
            'jawaban.*.jawaban' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong.',
            'jawaban.*.jawaban.required' => 'Pilihan jawaban tidak boleh kosong.'
        ];
    }
}
