<?php

namespace App\Security;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    const MANAGE = 'manage';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::MANAGE], true)
            && $subject instanceof Task;
    }

    protected function voteOnAttribute($attribute, $task, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }


        switch ($attribute) {
            case self::MANAGE:
                return $this->security->isGranted('ROLE_ADMIN')|| $user === $task->getUser();
            
                break;
        }

        return false;
    }

 
}