<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachments' => 'nullable|array',
            'attachments.*.description' => 'nullable|string|max:255',
            'attachments.*.file' => 'required|max:10240',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên công việc',
            'description' => 'Mô tả',
            'priority' => 'Mức độ ưu tiên',
            'assigned_to' => 'Người được giao',
            'project_id' => 'Dự án',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'attachments' => 'Tệp đính kèm',
            'attachments.*.description' => 'Mô tả tệp đính kèm',
            'attachments.*.file' => 'Tệp đính kèm',
        ];
    }


    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'name.max' => ':attribute không được vượt quá :max ký tự.',
            'priority.in' => ':attribute phải là một trong các giá trị: low, medium, high.',
            'exists' => ':attribute không tồn tại.',
            'start_date.date' => ':attribute phải là một ngày hợp lệ.',
            'end_date.date' => ':attribute phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => ':attribute phải bằng hoặc sau ngày bắt đầu.',
            'attachments.*.file.required' => 'Vui lòng chọn :attribute.',
            'attachments.*.file.file' => ':attribute phải là một tệp hợp lệ.',
            'attachments.*.file.mimes' => ':attribute phải có định dạng: jpg, jpeg, png, pdf, doc, docx, xlsx, txt.',
            'attachments.*.file.max' => ':attribute không được vượt quá 10MB.',
            'attachments.*.description.max' => ':attribute không được vượt quá :max ký tự.',
        ];
    }

}
