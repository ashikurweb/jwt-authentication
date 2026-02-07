<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'instructor_id' => $this->instructor_id,
            'instructor_name' => $this->instructor->name,
            'instructor_email' => $this->instructor->email,
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'total_orders' => $this->total_orders,
            'gross_amount' => (float) $this->gross_amount,
            'platform_fee' => (float) $this->platform_fee,
            'tax_withheld' => (float) $this->tax_withheld,
            'net_amount' => (float) $this->net_amount,
            'payment_method' => $this->payment_method,
            'payment_details' => $this->payment_details,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'notes' => $this->notes,
            'processed_by' => $this->processed_by,
            'processed_by_name' => $this->processedBy ? $this->processedBy->name : null,
            'processed_at' => $this->processed_at,
            'created_at' => $this->created_at,
        ];
    }
}
