<?php

namespace App\Enums;

enum ActionTrackerStatusEnum: string {
    case DELAYED = 'delated';
    case CANCELED = 'canceled';
    case ONGOING = 'ongoing';
    case NOTSTARTED = 'notstarted';
    case COMPLETE = 'complete';
}