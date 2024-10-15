<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_pinned' => 'required|in:on,off',
            'tags' => 'required|array',
            'tags.*' => 'integer|exists:tags,id', 
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];
    }
}