<?php

namespace App\Controller\User;

use Symfony\Component\Security\Core\Security;

class OwnUserInformation
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke()
    {
        return $this->security->getUser();
    }
}
