<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        
        return [
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'is_pinned' => 'sometimes|in:on,off',
            'tags' => 'sometimes|array',
            'tags.*' => 'integer|exists:tags,id', 
            'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif'
        ];
    }
}