<?php

namespace Corals\Modules\Shortener\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Shortener\Models\ShortDomain;
use Corals\User\Models\User;

class ShortDomainPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.shortener';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Shortener::shortDomain.view')) {
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
        return $user->can('Shortener::shortDomain.create');
    }

    /**
     * @param User $user
     * @param ShortDomain $shortDomain
     * @return bool
     */
    public function update(User $user, ShortDomain $shortDomain)
    {
        if ($user->can('Shortener::shortDomain.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param ShortDomain $shortDomain
     * @return bool
     */
    public function destroy(User $user, ShortDomain $shortDomain)
    {
        if ($user->can('Shortener::shortDomain.delete')) {
            return true;
        }

        return false;
    }
}
