<?php

namespace App\Service;

class SerializerService
{
    public static function isNullString(mixed $data): bool
    {
        return \is_scalar($data) && \in_array(\strtolower(\trim($data)), ['null', '']);
    }
}
