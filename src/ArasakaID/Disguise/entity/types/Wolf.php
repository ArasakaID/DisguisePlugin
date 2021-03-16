<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Wolf extends Entity{

    public const NETWORK_ID = self::WOLF;

    public function getName(): string
    {
        return "Wolf";
    }

}
