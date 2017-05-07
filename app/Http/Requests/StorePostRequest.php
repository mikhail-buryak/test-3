<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StorePostRequest extends Request
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
            'title' => ['required', 'string', 'max:200'],
            'tags' => ['array'],
            'tags.*' => ['string'],
            'image' => ['image', 'max:5000'],
            'body' => ['string'],
            'created_at' => ['string', 'date']
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        return new JsonResponse([
            'status' => 'error',
            'text' => trans('post.create.process.error'),
            'errors' => $errors
        ], 422);
    }
}
