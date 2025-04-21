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
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'manager_id' => 'required|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:not_started,in_progress,completed',
            'type' => 'required|in:user,department'
        ];

        if ($id) {
            $rules['name'] = 'nullable|max:255';
            $rules['description'] = 'nullable|string';
            $rules['start_date'] = 'nullable|date';
            $rules['end_date'] = 'nullable|date';
            $rules['manager_id'] = 'nullable|exists:users,id';
            $rules['type'] = 'nullable|in:user,department';
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
