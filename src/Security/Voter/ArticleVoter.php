<?php

namespace App\Security\Voter;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{

    const DELETE = 'delete';
    const EDIT = 'edit';
 public function __construct(Security $security)
 {
     $this->security = $security;
 }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::DELETE,
            self::EDIT
        ])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $article, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:

                return $this->canEdit($user , $article);
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::DELETE:

                return $this->canDelete($user , $article);


                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }

    public function canEdit(User $user, Article $article):bool{

        return $article->getUser() === $user
        || $this->security->isGranted('ROLE_ADMIN');
    }

    public function canDelete(User $user, Article $article):bool{

        return $article->getId() && 
        $this->canEdit($user,$article);

    }
}
