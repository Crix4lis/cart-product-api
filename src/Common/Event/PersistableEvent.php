<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

class PersistableEvent
{
    private int $surrogateEventId;
    private string $eventBody;
    private \DateTimeImmutable $occurredOn;
    private string $typeName;

    public function __construct(array $eventData, string $typeName)
    {
        $this->eventBody = json_encode($eventData);
        $this->occurredOn = new \DateTimeImmutable('now');
        $this->typeName = $typeName;
    }
}
