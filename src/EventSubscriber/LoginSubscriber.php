<?php 

namespace App\EventSubscriber;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $em;
    private $security;
   
    public function __construct(Security $security, EntityManagerInterface $em)
    {

            $this->em = $em;
            $this->security = $security;

        }
        public function onLogin()
        { 
            // code php pour mettre à jouur la date de derniére connexion pour l'utilisateur connecté
 
        $user = $this->security->getUser();
        dd($user);
        $user->setLastLoginAt(new DateTime());
        $this->em->flush();

        }
       
    
   
    public static function getSubscribedEvents(): array
    {
        // return les evenement au quels j'ai souscrit
        return [

            LoginSuccessEvent::class => 'onLogin'
            
        ];
    }
}