<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CityFromRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        // 取得錯誤資訊
        $responseData = $validator->errors();
        // 產生 JSON 格式的 response，(422 是 Laravel 預設的錯誤 http status，可自行更換) 
        $response = response()->json($responseData, 422);
        // 丟出 exception
        throw new HttpResponseException($response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "城市名稱 內容不能空白",
            "name.string" => "城市名稱 內容格式不符",
            "name.max" => "城市名稱 限制255個字",
        ];
    }
}
