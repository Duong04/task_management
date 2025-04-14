<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubtaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $id = $this->id;
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'due_date' => 'required|date',
            'attachments' => 'nullable|array',
            'attachments.*.description' => 'nullable|string|max:255',
            'attachments.*.file' => 'nullable|max:10240',
        ];

        if ($id) {
            $rules['attachments.*.id'] = 'nullable';
            $rules['status'] = 'nullable|in:not_started,in_progress,completed';
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
            'task_id' => 'Công việc',
            'due_date' => 'Ngày hết hạn',
            'status' => 'Trạng thái',
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
            'date' => ':attribute phải là một ngày hợp lệ.',
            'attachments.*.file.required' => 'Vui lòng chọn :attribute.',
            'attachments.*.file.file' => ':attribute phải là một tệp hợp lệ.',
            'attachments.*.file.mimes' => ':attribute phải có định dạng: jpg, jpeg, png, pdf, doc, docx, xlsx, txt.',
            'attachments.*.file.max' => ':attribute không được vượt quá 10MB.',
            'attachments.*.description.max' => ':attribute không được vượt quá :max ký tự.',
        ];
    }

}
