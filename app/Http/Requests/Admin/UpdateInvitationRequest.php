<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && ! $this->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'alpha_dash:ascii', 'min:3', 'max:80', Rule::unique('invitations', 'slug')->ignore($this->user()?->invitation?->id)],
            'bride_name' => ['required', 'string', 'max:255'],
            'bride_short_name' => ['required', 'string', 'max:80'],
            'bride_parents' => ['required', 'string', 'max:255'],
            'bride_instagram' => ['nullable', 'string', 'max:80'],
            'groom_name' => ['required', 'string', 'max:255'],
            'groom_short_name' => ['required', 'string', 'max:80'],
            'groom_parents' => ['required', 'string', 'max:255'],
            'groom_instagram' => ['nullable', 'string', 'max:80'],
            'event_at' => ['required', 'date'],
            'display_date' => ['required', 'string', 'max:120'],
            'akad_time' => ['required', 'string', 'max:120'],
            'reception_time' => ['required', 'string', 'max:120'],
            'venue' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'maps_url' => ['required', 'url:http,https', 'max:1000'],
            'quote' => ['required', 'string', 'max:1000'],
        ];
    }
}
