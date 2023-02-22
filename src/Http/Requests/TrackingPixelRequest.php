<?php

namespace Corals\Modules\Shortener\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Shortener\Models\TrackingPixel;

class TrackingPixelRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(TrackingPixel::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(TrackingPixel::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'short_domain_id' => 'nullable|exists:shortener_short_domains,id',
                'provider' => 'required|in:' . implode(',',
                        array_keys(config('shortener.models.tracking_pixel.providers'))),
                'head_script' => '',
                'body_script' => '',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|unique:shortener_tracking_pixels,name',
            ]);
        }

        if ($this->isUpdate()) {
            $trackingPixel = $this->route('tracking_pixel');

            $rules = array_merge($rules, [
                'name' => 'unique:shortener_tracking_pixels,name,' . $trackingPixel->id,
            ]);
        }

        return $rules;
    }
}
