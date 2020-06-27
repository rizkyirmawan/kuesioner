<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
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
                    'nip' => 'required|unique:dosen,nip',
                    'nama' => 'required',
                    'alamat' => 'required',
                    'nomor_telepon' => 'required|max:15',
                    'foto' => 'file|image|max:5000|nullable'
                ];
                break;
            case 'PATCH':
                return [
                    'nip' => 'required|unique:dosen,nip,' . $this->dosen->id,
                    'nama' => 'required',
                    'alamat' => 'required',
                    'nomor_telepon' => 'required|max:15',
                    'foto' => 'file|image|max:5000|nullable'
                ];
                break;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'nip.required' => 'NIP tidak boleh kosong.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.required' => 'Nama tidak boleh kosong.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'nomor_telepon.required' => 'Nomor telepon tidak boleh kosong.',
            'nomor_telepon.max' => 'Isi dengan nomor telepon yang valid.',
            'foto.image' => 'Format foto harus JPG/JPEG/PNG.',
            'foto.max' => 'Ukuran maksimal foto: 5MB.'
        ];
    }
}
