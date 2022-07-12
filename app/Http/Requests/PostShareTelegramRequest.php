<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class PostShareTelegramRequest
 *
 * @package App\Http\Requests
 */
final class PostShareTelegramRequest extends FormRequest
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
            'social_alias' => 'telegram',
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
            'post_id' => 'required|exists:posts,id,language_locale,' . $this->get('language_locale'),
            'data' => 'required|regex:/^([0-9\s\+\(\)]*)$/|min:10',
        ];
    }
}
