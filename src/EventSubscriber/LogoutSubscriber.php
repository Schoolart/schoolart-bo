<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function onLogoutEvent(LogoutEvent $event): void
    {
        if(in_array('application/json',$event->getRequest()->getAcceptableContentTypes())){
            $event->setResponse(new JsonResponse(null, 204));
        }
        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}