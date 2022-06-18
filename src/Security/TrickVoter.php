<?php
namespace App\Security;

use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\The;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class TrickVoter extends Voter
{
    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const COVER = 'cover';
    const DELETE = 'delete';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::CREATE, self::EDIT, self::DELETE, self::COVER])) {
            return false;
        }

        if (!$subject instanceof Trick) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Trick $trick */
        $trick = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($trick, $user);
            case self::CREATE:
                return $this->canCreate($trick, $user);
            case self::EDIT:
                return $this->canEdit($trick, $user);
            case self::COVER:
                return $this->canChangeCover($trick, $user);
            case self::DELETE:
                return $this->canDelete($trick, $user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Trick $trick, User $user): bool
    {
        return true;
    }

    private function canCreate(Trick $trick, User $user): bool
    {
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return true;
        }
        return false;
    }

    private function canEdit(Trick $trick, User $user): bool
    {
        return $this->canCreate($trick, $user);
    }

    private function canChangeCover(Trick $trick, User $user): bool
    {
        return $this->canEdit($trick, $user);

    }

    private function canDelete(Trick $trick, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        if ($user === $trick->getUser()) {
            return true;
        }
        return false;
    }

}