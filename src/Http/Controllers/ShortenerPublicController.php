<?php

namespace Corals\Modules\Shortener\Http\Controllers;

use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Models\TrackingPixel;
use Illuminate\Http\Request;

class ShortenerPublicController extends PublicBaseController
{
    public function splashPage(Request $request, $code)
    {
        $link = Link::findByCode($code);

        if (!$link->show_splash_page) {
            return redirect()->to($link->full_url);
        }

        $trackingPixels = TrackingPixel::query()->where(function ($query) use ($link) {
            $query->where('short_domain_id', $link->short_domain_id)
                ->orWhereNull('short_domain_id');
        })->active()->get();

        return view('Shortener::splash_page')->with(compact('link', 'trackingPixels'));
    }
}
