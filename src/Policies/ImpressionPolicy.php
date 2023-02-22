<?php

namespace Corals\Modules\Shortener\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Shortener\Models\Impression;
use Corals\User\Models\User;

class ImpressionPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.shortener';

    protected $skippedAbilities = ['create'];

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Shortener::impression.view')) {
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
        return false;
        //return $user->can('Shortener::impression.create');
    }

    /**
     * @param User $user
     * @param Impression $impression
     * @return bool
     */
    public function update(User $user, Impression $impression)
    {
        if ($user->can('Shortener::impression.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Impression $impression
     * @return bool
     */
    public function destroy(User $user, Impression $impression)
    {
        if ($user->can('Shortener::impression.delete')) {
            return true;
        }

        return false;
    }
}
