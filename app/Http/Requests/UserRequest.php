<?php

namespace App\Http\Requests;

use App\Enums\UserCourse;
use App\Enums\UserType;
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $unique = $this->isMethod('put')
            ? ',' . $this->route('user')->id . ',id'
            : '';

        $types = join(',', UserType::getValues());
        $courses = join(',', UserCourse::getValues());

        return [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email$unique",
            'password' => 'required|string|min:8',
            'enrollment_number' => 'required|numeric',
            'cellphone' => 'sometimes|nullable|string|max:15',
            'type' => "sometimes|required|in:{$types}",
            'course' => "required|in:{$courses}",
        ];
    }
}
