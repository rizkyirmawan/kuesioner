<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatkulRequest extends FormRequest
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
                    'kode' => 'required|unique:matkul,kode',
                    'mata_kuliah' => 'required',
                    'jurusan' => 'required|array|min:1',
                    'jurusan.*' => 'required'
                ];
                break;
            case 'PATCH':
                return [
                    'kode' => ['required', Rule::unique('matkul', 'kode')->ignore($this->id, 'kode')],
                    'mata_kuliah' => 'required',
                    'jurusan' => 'required|array|min:1',
                    'jurusan.*' => 'required'
                ];
                break;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode mata kuliah harus diisi.',
            'kode.unique' => 'Kode mata kuliah telah terdaftar.',
            'mata_kuliah.required' => 'Nama mata kuliah harus diisi.',
            'jurusan.required' => 'Pilih setidaknya satu jurusan.'
        ];
    }
}
