<?php

namespace App\Enums;

class BillStatus
{
    const GENERATED = 'generated';
    const SENT = 'sent';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const PAID = 'paid';
    const OVERDUE = 'overdue';
    const PARTIALLY_PAID = 'partially_paid';
    const CANCELLED = 'cancelled';
    const PROCESSING = 'processing';
    const SCHEDULED = 'scheduled';
}


?>
