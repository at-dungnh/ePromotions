<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEventRequest extends FormRequest
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
            'title' => 'required|unique:events|max:1000,title'. $this->get('event_id'),
            'description'=>'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'place' =>'required|max:1000',
             ];
    }
}
