<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGame extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'home_id' => 'required',
            'home_score' => 'required|integer|min:0',
            'away_id' => 'required',
            'away_score' => 'required|integer|min:0',
        ];
    }
}
