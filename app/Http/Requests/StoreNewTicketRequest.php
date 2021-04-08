<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewTicketRequest extends FormRequest
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
            'priority' => ['required','integer','exists:ticket_priorities,id'],
            'country' => ['required','integer','exists:countries,id'],
            'title' => ['required','min:5','max:255'],
            'description' => ['required','min:5','max:1000'],
        ];
    }
}
