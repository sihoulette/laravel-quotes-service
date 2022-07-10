<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class PostUpdateRequest
 *
 * @package App\Http\Requests
 */
final class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id,
            'language_locale' => LaravelLocalization::getCurrentLocale(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'language_locale' => 'required|exists:languages,locale',
            'content' => 'required|string|max:511|unique:posts,content,' . $this->route('post')
        ];
    }
}
