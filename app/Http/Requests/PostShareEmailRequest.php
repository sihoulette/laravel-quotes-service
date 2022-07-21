<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostShareEmailRequest
 *
 * @package App\Http\Requests
 */
final class PostShareEmailRequest extends FormRequest
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
            'social_alias' => 'e-mail',
            'language_locale' => App::getLocale(),
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
            'social_alias' => 'required|string|exists:socials,alias',
            'post_id' => 'required|exists:posts,id,language_locale,' . $this->get('language_locale'),
            'data' => 'required|string|email',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'data' => trans('requests.share.email'),
        ];
    }
}
