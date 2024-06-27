<?php

namespace App\Http\Requests\Backend;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can implement authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->route()->getName() == 'backend.book.store') {
            return [
                'title' => 'required|string|max:191',
                'description' => 'nullable|string',
                'author_id' => 'required|exists:users,id,isDeleted,no',
                'isbn' => 'required|string|max:191',
                'edition_language' => 'required|string|max:191',
                'publication_date' => 'required|date',
                'publisher' => 'required|string|max:191',
                'pages' => 'nullable|integer',
                'lessons' => 'nullable|integer',
                'tags' => 'nullable|string',
                'rating' => 'nullable|numeric|min:0|max:10',
                'min_age' => 'nullable|integer|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'discounted_price' => 'nullable|numeric|min:0',
                'discount_type' => 'nullable|in:fixed,percentage',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
                'availability' => 'required|boolean',
                'featured' => 'required|boolean',
                'on_sale' => 'required|boolean',
                'free_delivery' => 'required|boolean',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
                'status' => 'required|in:draft,published,archived',
            ];
        }

        if ($this->route()->getName() == 'backend.book.update') {
            return [
                'title' => 'required|string|max:191',
                'description' => 'nullable|string',
                'author_id' => 'required|exists:users,id,isDeleted,no',
                'isbn' => ['required', 'string', 'max:191', Rule::unique('books')->ignore($this->route('book'))],
                'edition_language' => 'required|string|max:191',
                'publication_date' => 'required|date',
                'publisher' => 'required|string|max:191',
                'pages' => 'nullable|integer',
                'lessons' => 'nullable|integer',
                'tags' => 'nullable|string',
                'rating' => 'nullable|numeric|min:0|max:10',
                'min_age' => 'nullable|integer|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'discounted_price' => 'nullable|numeric|min:0',
                'discount_type' => 'nullable|in:fixed,percentage',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
                'availability' => 'required|boolean',
                'featured' => 'required|boolean',
                'on_sale' => 'required|boolean',
                'free_delivery' => 'required|boolean',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
                'status' => 'required|in:draft,published,archived',
            ];
        }

        return [];
    }
}
