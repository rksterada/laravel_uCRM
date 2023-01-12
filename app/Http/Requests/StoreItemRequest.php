<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // trueにしていないとエラーになる
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // バリデーション
        return[
            'name' => ['required', 'max:50'], 
            'memo' => ['required', 'max:255'], 
            'price' => ['required', 'numeric'],
        ];
    }
}
