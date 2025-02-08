<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

use Task\App\Common\Exception\DataLayerException;

interface EventStore
{
    /**
     * @param PersistableEvent $event
     *
     * @throws DataLayerException
     */
    public function append(PersistableEvent $event): void;
}
