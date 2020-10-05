<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniRequest extends FormRequest
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
                    'nim' => 'required|unique:alumni,nim',
                    'nama' => 'required',
                    'jurusan' => 'required',
                    'alamat' => 'required',
                    'tahun_lulus' => 'required',
                    'nomor_telepon' => 'required|max:15',
                    'foto' => 'file|image|max:5000|nullable'
                ];
                break;
            case 'PATCH':
                return [
                    'nim' => 'required|unique:alumni,nim,' . $this->alumni->id,
                    'nama' => 'required',
                    'jurusan' => 'required',
                    'alamat' => 'required',
                    'tahun_lulus' => 'required',
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
            'nim.required' => 'NIM tidak boleh kosong.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama tidak boleh kosong.',
            'jurusan.required' => 'Silahkan pilih jurusan.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'nomor_telepon.required' => 'Nomor telepon tidak boleh kosong.',
            'nomor_telepon.max' => 'Isi dengan nomor telepon yang valid.',
            'tahun_lulus.required' => 'Silahkan pilih tahun lulus.',
            'foto.image' => 'Format foto harus JPG/JPEG/PNG.',
            'foto.max' => 'Ukuran maksimal foto: 5MB.'
        ];
    }
}
