<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Pig extends Entity{

    public const NETWORK_ID = self::PIG;

    public function getName(): string
    {
        return "Pig";
    }

}
