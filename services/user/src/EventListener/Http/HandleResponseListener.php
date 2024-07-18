<?php

namespace App\EventListener\Http;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class HandleResponseListener
{
    public function __invoke(ResponseEvent $event): void
    {
        //
    }
}