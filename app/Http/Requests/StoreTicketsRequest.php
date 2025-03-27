<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketsRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'priority_id'   => 'required|exists:priorities,id',
            'agent_id'      => 'nullable|exists:users,id',
            'files.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'categories'    => 'nullable|array',
            'categories.*'  => 'integer|exists:categories,id',
            'labels'        => 'nullable|array',
            'labels.*'      => 'integer|exists:labels,id',
        ];
    }
}
