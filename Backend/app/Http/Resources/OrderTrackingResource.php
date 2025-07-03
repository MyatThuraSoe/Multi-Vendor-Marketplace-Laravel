<?php
// app/Http/Resources/OrderTrackingResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTrackingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order' => new OrderResource($this->order),
            'tracking_number' => $this->tracking_number,
            'carrier' => $this->carrier,
            'current_status' => $this->current_status,
            'estimated_delivery' => $this->estimated_delivery,
            'tracking_history' => $this->tracking_history,
            'timeline' => [
                'order_placed' => [
                    'date' => $this->order->created_at,
                    'status' => 'completed',
                    'description' => 'Order placed successfully',
                ],
                'payment_confirmed' => [
                    'date' => $this->payment_confirmed_at,
                    'status' => $this->payment_confirmed_at ? 'completed' : 'pending',
                    'description' => 'Payment confirmed',
                ],
                'processing' => [
                    'date' => $this->processing_started_at,
                    'status' => $this->getTimelineStatus('processing'),
                    'description' => 'Order is being processed',
                ],
                'shipped' => [
                    'date' => $this->order->shipped_at,
                    'status' => $this->getTimelineStatus('shipped'),
                    'description' => 'Order has been shipped',
                ],
                'delivered' => [
                    'date' => $this->order->delivered_at,
                    'status' => $this->getTimelineStatus('delivered'),
                    'description' => 'Order delivered',
                ],
            ],
        ];
    }
}
