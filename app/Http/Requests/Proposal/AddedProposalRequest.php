<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class AddedProposalRequest extends FormRequest
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
        return [
            "title" => "required|string",
            "description" => "required",
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ];
    }
    // Adam Ahmed -> Added ErrorBag for the Speaker Modal Returning Errors MSGS
    protected $errorBag = 'speaker';
}
