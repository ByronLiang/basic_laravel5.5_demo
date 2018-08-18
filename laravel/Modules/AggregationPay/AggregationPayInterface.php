<?php

namespace Modules\AggregationPay;

use Modules\AggregationPay\Entities\PaymentRecord;
use Modules\AggregationPay\Entities\RefundRecord;
use Illuminate\Support\Collection;

/**
 * @property Collection    $paymentRecords
 * @property PaymentRecord $paymentRecord
 * @property PaymentRecord $paymentRecordPaid
 * @property Collection    $refundRecords
 * @property RefundRecord  $refundRecord
 */
interface AggregationPayInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|PaymentRecord
     */
    public function paymentRecords();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|PaymentRecord
     */
    public function paymentRecord();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|PaymentRecord
     */
    public function paymentRecordPaid();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|RefundRecord
     */
    public function refundRecords();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|RefundRecord
     */
    public function refundRecord();
}
