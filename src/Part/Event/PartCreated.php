<?php

declare(strict_types=1);

namespace App\Part\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Konstantin Grachev <me@grachevko.ru>
 */
final class PartCreated extends GenericEvent
{
}
