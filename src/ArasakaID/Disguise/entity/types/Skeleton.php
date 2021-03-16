<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Skeleton extends Entity{

    public const NETWORK_ID = self::SKELETON;

    public function getName(): string
    {
        return "Skeleton";
    }

}