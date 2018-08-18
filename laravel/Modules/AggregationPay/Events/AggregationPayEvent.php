<?php

namespace Modules\AggregationPay\Events;

use Modules\AggregationPay\Entities\PaymentRecord;
use Modules\AggregationPay\Entities\RefundRecord;
use Illuminate\Queue\SerializesModels;

class AggregationPayEvent
{
    use SerializesModels;

    /**
     * @var PaymentRecord|RefundRecord
     */
    public $record;

    /**
     * PaymentSuccess constructor.
     *
     * @param PaymentRecord|RefundRecord $record
     */
    public function __construct($record)
    {
        $this->record = $record;
    }

    /**
     * @return bool
     */
    public function isPayment()
    {
        return $this->record instanceof PaymentRecord;
    }

    /**
     * @return bool
     */
    public function isRefund()
    {
        return $this->record instanceof RefundRecord;
    }
}
