<?php

namespace Corals\Modules\Shortener\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Shortener\Models\TrackingPixel;
use Corals\User\Models\User;

class TrackingPixelPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.shortener';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Shortener::tracking_pixel.view')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Shortener::tracking_pixel.create');
    }

    /**
     * @param User $user
     * @param TrackingPixel $trackingPixel
     * @return bool
     */
    public function update(User $user, TrackingPixel $trackingPixel)
    {
        if ($user->can('Shortener::tracking_pixel.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param TrackingPixel $trackingPixel
     * @return bool
     */
    public function destroy(User $user, TrackingPixel $trackingPixel)
    {
        if ($user->can('Shortener::tracking_pixel.delete')) {
            return true;
        }
        return false;
    }

}
