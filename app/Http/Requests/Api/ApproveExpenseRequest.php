<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApproveExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'exists:expenses',
            'approver_id' => 'required|exists:approvers,id'
        ];
    }
    public function messages(): array
    {
        return [
            // 'id.required'   => 'parameter id is required',
            'id.exists'   => 'expense data doesnt exists',
            'approver_id.required'   => 'approver id is required',
            'approver_id.exists'   => 'approver data doesnt exists',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ], 422));
    }
}
