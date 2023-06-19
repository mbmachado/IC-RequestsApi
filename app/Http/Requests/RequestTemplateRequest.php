<?php

namespace App\Http\Requests;

use App\Enums\RequestTemplateStatus;
use Illuminate\Foundation\Http\FormRequest;

class RequestTemplateRequest extends FormRequest
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
        $status = join(',', RequestTemplateStatus::getValues());

        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => "sometimes|required|in:$status",
            'show_title_field' => 'required|boolean',
            'title_field_label' => 'nullable|string|max:255',
            'title_field_placeholder' => 'nullable|string|max:255',
            'title_field_required' => 'required|boolean',
            'show_details_field' => 'required|boolean',
            'details_field_label' => 'nullable|string|max:255',
            'details_field_placeholder' => 'nullable|string|max:255',
            'details_field_required' => 'required|boolean',
            'show_attachments_field' => 'required|boolean',
            'attachments_field_label' => 'nullable|string|max:255',
            'attachments_field_required' => 'required|boolean',
            'workflow_id' => 'required|numeric',
        ];
    }
}
