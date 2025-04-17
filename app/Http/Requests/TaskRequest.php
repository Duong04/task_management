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
        $id = $this->id;
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'required|exists:users,id',
            'created_by' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'due_date' => 'required|date',
            'attachments' => 'nullable|array',
            'attachments.*.file' => 'nullable|max:10240',
            'status' => 'required|in:not_started,in_progress,completed'
        ];

        if ($id) {
            $rules['name'] = 'nullable|string|max:255';
            $rules['status'] = 'nullable|in:not_started,in_progress,completed';
            $rules['description'] = 'nullable|string';
            $rules['priority'] = 'nullable|in:low,medium,high';
            $rules['progress'] = 'nullable|integer';
            $rules['assigned_to'] = 'nullable|exists:users,id';
            $rules['created_by'] = 'nullable|exists:users,id';
            $rules['project_id'] = 'nullable|exists:projects,id';
            $rules['due_date'] = 'nullable|date';
            $rules['attachments.*.id'] = 'nullable';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên công việc',
            'description' => 'Mô tả',
            'priority' => 'Mức độ ưu tiên',
            'assigned_to' => 'Người được giao',
            'created_by' => 'Người tạo',
            'project_id' => 'Dự án',
            'due_date' => 'Ngày hoàn thành',
            'attachments' => 'Tệp đính kèm',
            'status' => 'Trạng thái',
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
            'due_date.date' => ':attribute phải là một ngày hợp lệ.',
            'attachments.*.file.required' => 'Vui lòng chọn :attribute.',
            'attachments.*.file.file' => ':attribute phải là một tệp hợp lệ.',
            'attachments.*.file.mimes' => ':attribute phải có định dạng: jpg, jpeg, png, pdf, doc, docx, xlsx, txt.',
            'attachments.*.file.max' => ':attribute không được vượt quá 10MB.',
        ];
    }

}
