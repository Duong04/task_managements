<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $id = $this->id;
        
        $rules = [
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable',
        ];

        if ($id) {
            $rules['name'] .= ",$id";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống!',
            'max' => ':attribute không được lớn hơn :max ký tự!',
            'unique' => ':attribute này đã tồn tại!',
            'string' => 'Trường này phải là 1 chuỗi!'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên vai trò',
            'description' => 'Mô tả',
        ]; 
    }
}
