<?php

namespace App\Support;

use Spatie\EventSourcing\EventSerializers\EventSerializer;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class JsonSerializer implements EventSerializer
{
    public function serialize(ShouldBeStored $event): string
    {
        return json_encode(['event' => serialize($event)]);
    }

    public function deserialize(string $eventClass, string $json, int $version, string $metadata = null): ShouldBeStored
    {
        return unserialize(json_decode($json, true)['event']);
    }
}
