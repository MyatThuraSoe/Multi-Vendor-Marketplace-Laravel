<?php
// app/Http/Resources/AdminDashboardResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_users' => $this->total_users,
            'total_sellers' => $this->total_sellers,
            'total_buyers' => $this->total_buyers,
            'pending_sellers' => $this->pending_sellers,
            'total_products' => $this->total_products,
            'active_products' => $this->active_products,
            'total_orders' => $this->total_orders,
            'pending_orders' => $this->pending_orders,
            'total_revenue' => $this->total_revenue,
            'commission_earned' => $this->commission_earned,
            'pending_withdrawals' => $this->pending_withdrawals,
            'total_withdrawal_amount' => $this->total_withdrawal_amount,
            'recent_orders' => OrderResource::collection($this->recent_orders),
            'recent_sellers' => SellerProfileResource::collection($this->recent_sellers),
            'recent_withdrawals' => WithdrawalResource::collection($this->recent_withdrawals),
            'monthly_revenue' => $this->monthly_revenue,
            'popular_categories' => CategoryResource::collection($this->popular_categories),
            'top_selling_products' => ProductListResource::collection($this->top_selling_products),
        ];
    }
}
