<?php

namespace App\Utils\Log;

enum Action
{
    case FROM_WAREHOUSE_TO_WAREHOUSE;
    case FROM_VAN_TO_VAN;
    case FROM_WAREHOUSE_TO_VAN;
    case FROM_VAN_TO_WAREHOUSE;
}
