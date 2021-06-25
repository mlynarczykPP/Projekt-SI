<?php

/**
 * NoteAuthor Voter.
 */

namespace App\Security\Voter;

use App\Entity\Note;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NoteAuthorVoter
 */
class NoteAuthorVoter extends Voter
{
    /**
     * Support.
     *
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['VIEW', 'EDIT', 'DELETE'])
            && $subject instanceof Note;
    }

    /**
     * Vote on attribute.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'DELETE':
            case 'EDIT':
            case 'VIEW':
                return $this->isAuthor($subject, $user);
                break;
            default:
                return false;
                break;
        }

        return false;
    }

    /**
     * Is author.
     *
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    private function isAuthor($subject, User $user): bool
    {
        return $subject->getAuthor() === $user;
    }
}
