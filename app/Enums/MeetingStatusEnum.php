<?php

namespace App\Enums;

enum MeetingStatusEnum: string {
    case SIGNED = 'signed';
    case QOURMREACHED = 'qourmreached';
    case NOTSIGNED = 'notsigned';
    case PARTIAL = 'partial';
}