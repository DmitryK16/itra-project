<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyRequest extends FormRequest
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
            'name' => 'required|max:265',
            'small_descriptions' => 'required|min:10|max:1000',
            'video' => 'nullable',
            'subject_id' => 'required|integer',
            'required_amount' => 'required|numeric',
        ];
    }

    public function execute()
    {
        $data = $this->validated();

        return Company::create([
            'subject_id' => $data['subject_id'],
            'video' => $data['video'],
            'small_descriptions' => $data['small_descriptions'],
            'name' => $data['name'],
            'required_amount' => $data['required_amount'],
            'user_id' => Auth::id(),
        ]);
    }
}
