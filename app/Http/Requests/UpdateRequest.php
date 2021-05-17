<?php

namespace App\Http\Requests;

use App\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'descriptions' => 'required|min:10|max:1000',
            'img' => 'image|nullable',
            'company_id' => 'required|integer',
        ];
    }

    public function update(News $news)
    {
        $data = $this->validated();

        $imgNews = $this->file('img');

        $imgPath = $imgNews ? $imgNews->store('news', 'public') : null;

        $news->company_id = $data['company_id'];
        $news->img = $imgPath;
        $news->name = $data['name'];
        $news->descriptions = $data['descriptions'];

        return $news->save();
    }
}
