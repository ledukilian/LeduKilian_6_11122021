<?php
namespace App\Security;

use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class TrickVoter extends Voter
{
    /* All trick functionnalities */
    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const COVER = 'cover';
    const DELETE = 'delete';
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        /* If attribute is not supported, return false */
        if (!in_array($attribute, [self::DELETE])) {
            return false;
        }

        /* If attribute is not a Trick, return false */
        if (!$subject instanceof Trick) {
            return false;
        }

        /* Else, return true, attribute and subject are supported */
        return true;
    }


    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Trick $trick */
        $trick = $subject;

        /* Switch with only one case supported (DELETE) */
        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($trick, $user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Trick $trick
     * @param User  $user
     * @return bool
     */
    private function canDelete(Trick $trick, User $user): bool
    {
        /* If the user is Admin */
        if ($this->security->isGranted('ROLE_ADMIN')) {
            /* Then he can delete */
            return true;
        /* Or the user is owner of the trick */
        } elseif ($user === $trick->getUser()) {
            /* Then he can delete */
            return true;
        }
        /* Else he can't delete the trick */
        return false;
    }

}
