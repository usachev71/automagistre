<?php

declare(strict_types=1);

namespace App\Order\Event;

use App\Order\Entity\Order;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @method Order getSubject()
 *
 * @author Konstantin Grachev <me@grachevko.ru>
 */
final class OrderClosed extends GenericEvent
{
    public function __construct(Order $order, array $arguments = [])
    {
        parent::__construct($order, $arguments);
    }
}
