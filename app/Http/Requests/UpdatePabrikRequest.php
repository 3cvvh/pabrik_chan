<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePabrikRequest extends FormRequest
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
            'name' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email',
            'gambar' => 'nullable|image|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pabrik wajib diisi.',
            'alamat.required' => 'Alamat pabrik wajib diisi.',
            'no_telepon.required' => 'Nomor telepon pabrik wajib diisi.',
            'email.required' => 'Email pabrik wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ];
    }
}
