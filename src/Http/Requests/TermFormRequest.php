<?php

namespace TypiCMS\Modules\Taxonomies\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class TermFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'taxonomy_id' => 'required|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_with:title.*',
        ];
    }
}
