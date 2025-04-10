<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];

        if ($id) {
            $rules['status'] = 'nullable|in:not_started,in_progress,completed';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống!',
            'string' => ':attribute phải là một chuỗi!',
            'max' => ':attribute không được lớn hơn :max ký tự!',
            'date' => ':attribute không đúng định dạng ngày tháng!',
            'after_or_equal' => ':attribute phải lớn hơn hoặc bằng :date!',
        ];
    }
    
    public function attributes(): array
    {
        return [
            'name' => 'Tên dự án',
            'description' => 'Mô tả',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'status' => 'Trạng thái',
        ];
    }
}
