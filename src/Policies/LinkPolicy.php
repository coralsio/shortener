<?php

namespace Corals\Modules\Shortener\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Shortener\Models\Link;
use Corals\User\Models\User;

class LinkPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.shortener';
    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Shortener::link.view')) {
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
        return $user->can('Shortener::link.create');
    }

    /**
     * @param User $user
     * @param Link $link
     * @return bool
     */
    public function update(User $user, Link $link)
    {
        if ($user->can('Shortener::link.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Link $link
     * @return bool
     */
    public function destroy(User $user, Link $link)
    {
        if ($user->can('Shortener::link.delete')) {
            return true;
        }
        return false;
    }

}
