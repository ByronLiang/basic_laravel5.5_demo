<?php

namespace Modules\AggregationPay;

use Modules\AggregationPay\Entities\PaymentRecord;
use Modules\AggregationPay\Entities\RefundRecord;

/**
 * @mixin \Eloquent
 */
trait AggregationPayTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|PaymentRecord
     */
    public function paymentRecords()
    {
        return $this->morphMany(PaymentRecord::class, 'able');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|PaymentRecord
     */
    public function paymentRecord()
    {
        return $this->morphOne(PaymentRecord::class, 'able');
    }

    /**
     * 获取已经支付的支付记录.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|PaymentRecord
     */
    public function paymentRecordPaidRefunded()
    {
        return $this->paymentRecord()->whereIn('status', [PaymentRecord::STATUS_PAID, PaymentRecord::STATUS_REFUNDED]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|RefundRecord
     */
    public function refundRecords()
    {
        return $this->morphMany(RefundRecord::class, 'able');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|RefundRecord
     */
    public function refundRecordsRefunded()
    {
        return $this->refundRecords()->where('status', RefundRecord::STATUS_REFUNDED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|RefundRecord
     */
    public function refundRecord()
    {
        return $this->morphOne(RefundRecord::class, 'able');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|RefundRecord
     */
    public function refundRecordRefunded()
    {
        return $this->refundRecord()->where('status', RefundRecord::STATUS_REFUNDED);
    }
}
