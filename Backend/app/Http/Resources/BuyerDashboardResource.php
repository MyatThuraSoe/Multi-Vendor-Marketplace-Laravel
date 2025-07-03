<?php
// app/Http/Resources/BuyerDashboardResource.php
namespace App\Http\Resources;

use Illuminate.Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_orders' => $this->total_orders,
            'pending_orders' => $this->pending_orders,
            'processing_orders' => $this->processing_orders,
            'shipped_orders' => $this->shipped_orders,
            'delivered_orders' => $this->delivered_orders,
            'cancelled_orders' => $this->cancelled_orders,
            'total_spent' => $this->total_spent,
            'recent_orders' => OrderResource::collection($this->recent_orders),
            'pending_reviews' => $this->pending_reviews,
            'favorite_categories' => CategoryResource::collection($this->favorite_categories),
            'recommended_products' => ProductListResource::collection($this->recommended_products),
            'order_status_breakdown' => $this->order_status_breakdown,
            'monthly_spending' => $this->monthly_spending,
        ];
    }
}
