<?php

namespace Corals\Modules\Shortener\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Shortener\Models\Link;

class LinkRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Link::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Link::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'expired_at' => 'nullable|date',
                'status' => 'required',
                'url' => 'required|url'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
//                'url' => 'required|unique:shortener_links,url',
            ]);
        }

        if ($this->isUpdate()) {
            $link = $this->route('link');

            $rules = array_merge($rules, [
//                'url' => 'unique:shortener_links,url,' . $link->id,
            ]);
        }

        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        if ($this->isStore() || $this->isUpdate()) {
            $data = $this->all();

            if ($this->isStore() && $this->is('api*')) {
                //TODO could be changed in future depends on the business
                $data['status'] = 'active';
            }

            $data['show_splash_page'] = data_get($data, 'show_splash_page', false);

            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
    }
}
