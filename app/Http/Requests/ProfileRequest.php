<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $id = auth()->user()->id;
        $rules = [
            'name' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:users,email,'.$id,
            'userDetail.address' => 'nullable|string|max:255',
            'userDetail.phone' => 'nullable|string|max:11|min:9',
            'userDetail.dob' => 'nullable|date',
            'userDetail.gender' => 'nullable|in:male,female',
            'avatar' => 'nullable|image'
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống!',
            'string' => ':attribute phải là chuỗi!',
            'max' => ':attribute không được vượt quá :max ký tự!',
            'min' => ':attribute không được nhỏ hơn :min ký tự!',
            'email' => ':attribute phải là một địa chỉ email hợp lệ!',
            'unique' => ':attribute đã tồn tại!',
            'in' => ':attribute không hợp lệ!',
            'exists' => ':attribute không tồn tại'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'staff.phone' => 'Số điện thoại',
            'staff.dob' => 'Ngày sinh',
            'staff.gender' => 'Giới tính',
            'staff.address' => 'Địa chỉ',
        ];
    }
}
