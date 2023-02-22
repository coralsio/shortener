<?php

namespace Corals\Modules\Shortener\Classes;

use Corals\Modules\Shortener\Models\ShortDomain;
use Corals\Modules\Shortener\Models\UrlCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Shortener
{
    const URL_CODES_TABLE = 'shortener_url_codes';
    const CODE_COLUMN = 'code';
    const CODE_LENGTH = 5;

    /**
     * Shortener constructor.
     */
    function __construct()
    {
    }

    /**
     * @return array
     */
    public function getShortDomainsList()
    {
        $domains = [];

        ShortDomain::query()->each(function ($domain) use (&$domains) {
            $domains[$domain->id] = sprintf('%s (%s)', $domain->title, $domain->base_url);
        });

        return $domains;
    }

    public function generateCodeForLink($link)
    {
        $data['generation_code'] = now()->format('mdYhis') . '_manual';

        $maxTries = 100;

        foreach (range(1, 100) as $index) {
            $code = Str::random(self::CODE_LENGTH);

            if (!DB::table(self::URL_CODES_TABLE)->where(self::CODE_COLUMN, $code)->exists()) {
                $data[self::CODE_COLUMN] = $code;

                return UrlCode::query()->create(array_merge([
                    'link_id' => $link->id,
                    'short_domain_id' => optional($link->shortDomain)->id,
                ], $data));
            }
        }
    }
}
