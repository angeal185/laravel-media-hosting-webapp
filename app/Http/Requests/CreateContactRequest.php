<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateContactRequest extends Request
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
          'sender_name' => 'required',
          'sender_email' => 'required|email',
          'sender_msg' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'sender_name.required' => 'Please Enter Your Full Name',
            'sender_email.required' => 'Please Enter Your E-mail',
            'sender_email.email' => 'Please Enter a Valid E-mail',
            'sender_msg.required' => 'Please Enter Your Message'
        ];
    }
}
