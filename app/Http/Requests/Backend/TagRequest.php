<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->route()->getName() == 'admin.tag.store'){
            return [
                'name' => 'required|string|max:50|unique:tags',
                'status' => 'required|in:active,inactive',
            ];
        }
        if($this->route()->getName() == 'admin.tag.update'){
            return [
                'name' => ['required','string','max:50', Rule::unique('tags')->ignore($this->id)],
                'status' => 'required|in:active,inactive',
            ];
        }
    }
}
