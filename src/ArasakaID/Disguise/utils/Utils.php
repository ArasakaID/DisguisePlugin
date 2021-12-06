<?php

namespace ArasakaID\Disguise\utils;

use pocketmine\math\Vector3;

class Utils {

    public static function vectorToString(Vector3 $pos): string{
        return "{$pos->getFloorX()}:{$pos->getFloorY()}:{$pos->getFloorZ()}";
    }

}