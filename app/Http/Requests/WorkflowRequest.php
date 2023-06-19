<?php

namespace App\Http\Requests;

use App\Enums\AssigneeType;
use App\Enums\StepType;
use App\Enums\WorkflowStatus;
use Illuminate\Foundation\Http\FormRequest;

class WorkflowRequest extends FormRequest
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
        $status = join(',', WorkflowStatus::getValues());
        $stepTypes = join(',', StepType::getValues());
        $assigneeTypes = join(',', AssigneeType::getValues());

        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => "sometimes|required|in:$status",
            'steps.*.name' => 'required|string|max:255',
            'steps.*.description' => 'nullable|string|max:255',
            'steps.*.assignee_type' => "sometimes|required|in:$assigneeTypes",
            'steps.*.step_type' => "sometimes|required|in:$stepTypes",
            'steps.*.order' => 'required|numeric',
        ];
    }
}
