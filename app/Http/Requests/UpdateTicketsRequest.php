<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketsRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'sometimes|string|max:255',
            'description'   => 'sometimes|string',
            'priority_id'   => 'sometimes|exists:priorities,id',
            'agent_id'      => 'nullable|exists:users,id',
            'files.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'categories'    => 'nullable|array',
            'categories.*'  => 'integer|exists:categories,id',
            'labels'        => 'nullable|array',
            'labels.*'      => 'integer|exists:labels,id',
        ];
    }
}
