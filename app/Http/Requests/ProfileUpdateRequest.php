<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nim' => ['required', 'string', 'max:50', 'not_regex:/<[^>]*>/'],
            'institusi' => ['required', 'string', 'max:150', 'not_regex:/<[^>]*>/'],
            'nomor_telp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/', 'not_regex:/<[^>]*>/'],
            'alamat' => ['required', 'string', 'max:500', 'not_regex:/<[^>]*>/'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'nim' => 'NIM',
            'institusi' => 'Institusi/Sekolah',
            'nomor_telp' => 'Nomor telepon',
            'alamat' => 'Alamat',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.not_regex' => ':attribute tidak boleh berisi tag HTML.',
            'nomor_telp.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, +, atau -.',
        ];
    }
}
