<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Chicken extends Entity{

    public const NETWORK_ID = self::CHICKEN;

    public function getName(): string
    {
        return "Chicken";
    }

}
