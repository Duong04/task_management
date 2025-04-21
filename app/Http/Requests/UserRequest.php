<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'is_active' => 'required',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'user_detail.position_id' => 'nullable|exists:positions,id',
            'user_detail.phone' => 'nullable|string|max:11|min:9',
            'user_detail.address' => 'nullable|string|max:250',
            'user_detail.dob' => 'nullable|date',
            'user_detail.gender' => 'nullable|in:female,male'
        ];

        if ($id) {
            $rules['email'] .= ",$id";
            $rules['password'] = 'nullable|string|min:8|max:255';
            $rules['role_id'] = 'nullable';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống!',
            'email' => 'Vui lòng nhập đúng định dạng email!',
            'min' => ':attribute không được nhỏ hơn :min ký tự!',
            'max' => ':attribute không được lớn hơn :max ký tự!',
            'exists' => ':attribute không tồn tại!',
            'date' => ':attribute không đúng định dạng!',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên người dùng',
            'is_active' => 'Trạng thái',
            'password' => 'Mật khẩu',
            'email' => 'Email',
            'role_id' => 'Vai trò',
            'user_detail.position_id' => 'Chức vụ',
            'user_detail.phone' => 'Số điện thoại',
            'user_detail.address' => 'Địa chỉ',
            'user_detail.dob' => 'Ngày sinh',
            'user_detail.gender' => 'Giới tính'
        ]; 
    }
}
