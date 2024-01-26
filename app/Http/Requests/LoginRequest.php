<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->failureResponse();

        throw new HttpResponseException(response()->json($response, 422));
    }

    /**
     * Return a failure response.
     *
     * @return array
     */
    protected function failureResponse()
    {
        return ['status' => 'failure'];
    }
}
