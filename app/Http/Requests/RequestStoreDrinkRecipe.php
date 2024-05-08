<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreDrinkRecipe extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'ingredient' => 'required',
            'step' => 'required',
            'purchase_link' => 'required',
        ];

        if ($this->getMethod() === 'POST') {
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'category_id.required' => 'Kategori wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama wajib diisi.',
            'ingredient.required' => 'Bahan wajib diisi.',
            'step.required' => 'Langkah wajib diisi.',
            'image.required' => 'Gambar wajib diisi.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'purchase_link.required' => 'Link pembelian wajib diisi.',
        ];
    }
}
