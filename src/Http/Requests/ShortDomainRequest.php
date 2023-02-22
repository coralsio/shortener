<?php

namespace Corals\Modules\Shortener\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Shortener\Models\ShortDomain;

class ShortDomainRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(ShortDomain::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(ShortDomain::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'title' => 'required',
                'status' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'base_url' => 'required|url|unique:shortener_short_domains,base_url',
            ]);
        }

        if ($this->isUpdate()) {
            $shortDomain = $this->route('short_domain');

            $rules = array_merge($rules, [
                'base_url' => 'required|url|unique:shortener_short_domains,base_url,' . $shortDomain->id,
            ]);
        }

        return $rules;
    }
}
