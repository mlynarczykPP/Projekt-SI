<?php

namespace App\Security\Voter;

use App\Entity\Note;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class NoteAuthorVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['VIEW', 'EDIT', 'DELETE'])
            && $subject instanceof Note;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'VIEW':
            case 'EDIT':
            case 'DELETE':
                if ($subject->getAuthor() === $user) {
                    return true;
                }
                break;
            default:
                return false;
                break;
        }

        return false;
    }
}