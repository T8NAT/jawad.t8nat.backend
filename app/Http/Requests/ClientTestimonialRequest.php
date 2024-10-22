<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ClientTestimonialRequest extends FormRequest
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
        $rules = [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required'  => __('validation.required', [ 'attribute' => __('message.name') ]),
            'subtitle.required'  => __('validation.required', [ 'attribute' => __('message.type') ]),
            'description.required'  => __('validation.required', [ 'attribute' => __('message.review') ]),
        ];
    }

     /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        $data = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'all_message' =>  $validator->errors(),
            'event' => 'validation',
        ];

        if ($this->ajax()) {
            $data['status'] = false;
            throw new HttpResponseException(response()->json($data,200));
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
        }
    }
}
