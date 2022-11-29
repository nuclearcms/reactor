<?php

namespace Nuclear\Reactor\Http\Requests;

use Umomega\Auth\Http\Requests\UpdateUser as BaseRequest;

class UpdateUser extends BaseRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            ['contents_list' => 'nullable|array']
        );
    }
}
