<?php

namespace App\Enums;
enum MinuteStatusEnum: string {
    case SIGNED = 'signed';
    case QOURMREACHED = 'qourmreached';
    case NOTSIGNED = 'notsigned';
    case PARTIAL = 'partial';
}

