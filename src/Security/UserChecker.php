<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * Checks the user account before authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
        if (!$user->isVerified()) {
            // $uniqueResendEmailurl = ....

            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas activé. Veuillez confirmer 
            votre inscription en cliquant sur le lien qui vous a été envoyé par email, pensez à vérifier dans vos spams. Vous pouvez demander un nouveau mail de confirmation en bas de ce formulaire.");
        }
    }

    /**
     * Checks the user account after authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

    }
}
