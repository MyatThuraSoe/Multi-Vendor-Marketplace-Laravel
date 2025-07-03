<?php
// app/Http/Resources/SellerDashboardResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_products' => $this->total_products,
            'active_products' => $this->active_products,
            'out_of_stock' => $this->out_of_stock,
            'total_orders' => $this->total_orders,
            'pending_orders' => $this->pending_orders,
            'processing_orders' => $this->processing_orders,
            'shipped_orders' => $this->shipped_orders,
            'delivered_orders' => $this->delivered_orders,
            'total_earnings' => $this->total_earnings,
            'available_earnings' => $this->available_earnings,
            'pending_earnings' => $this->pending_earnings,
            'withdrawn_earnings' => $this->withdrawn_earnings,
            'recent_orders' => OrderResource::collection($this->recent_orders),
            'recent_reviews' => ReviewResource::collection($this->recent_reviews),
            'low_stock_products' => ProductListResource::collection($this->low_stock_products),
            'top_selling_products' => ProductListResource::collection($this->top_selling_products),
            'monthly_sales' => $this->monthly_sales,
            'order_status_breakdown' => $this->order_status_breakdown,
            'withdrawal_history' => WithdrawalResource::collection($this->recent_withdrawals),
        ];
    }
}
