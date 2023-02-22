<?php

namespace Corals\Modules\Shortener\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Shortener\Facades\Shortener;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class Link extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'shortener.models.link';

    protected $table = 'shortener_links';

    protected $appends = ['full_url'];

    protected $casts = [
        'properties' => 'json',
        'parameters' => 'json',
        'show_splash_page' => 'boolean',
        'expired_at' => 'datetime',
    ];

    protected $guarded = ['id'];

    /**
     * @return HasOne
     */
    public function code(): HasOne
    {
        return $this->hasOne(UrlCode::class);
    }

    public function getFullUrlAttribute()
    {
        $url = $this->url;
        $parameters = $this->parameters ?? [];

        return trim(sprintf(
            "%s?%s",
            $url,
            http_build_query(
                array_combine(
                Arr::pluck($parameters, 'key'),
                Arr::pluck($parameters, 'value')
            )
            )
        ), '?');
    }

    /**
     * @return BelongsTo
     */
    public function shortDomain(): BelongsTo
    {
        return $this->belongsTo(ShortDomain::class);
    }

    public function impressions()
    {
        return $this->hasMany(Impression::class);
    }

    public function generateShortURL()
    {
        if ($this->short_url) {
            return $this->short_url;
        }

        $shortDomain = optional($this->shortDomain);

        $urlCode = UrlCode::query()
            ->whereNull('link_id')
            ->lockForUpdate()->first();

        if (! $urlCode) {
            $urlCode = Shortener::generateCodeForLink($this);
        } else {
            $urlCode->update([
                'link_id' => $this->id,
                'short_domain_id' => $shortDomain->id,
            ]);
        }

        $data['code'] = $urlCode->code;

        $shortURL = sprintf('%s/l/%s', trim($shortDomain->base_url ?? config('app.url'), '/'), $urlCode->code);

        $parsed = parse_url($shortURL);

        if (empty($parsed['scheme'])) {
            $shortURL = 'http://' . ltrim($shortURL, '/');
        }

        $data['short_url'] = $shortURL;

        $this->update($data);

        return $shortURL;
    }

    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->lt(now());
    }

    /**
     * @param $code
     * @return Builder|Model
     */
    public static function findByCode($code)
    {
        $link = self::query()
            ->where('code', $code)
            ->firstOrFail();

        if ($link->isExpired()) {
            abort(404);
        }

        return $link;
    }
}
