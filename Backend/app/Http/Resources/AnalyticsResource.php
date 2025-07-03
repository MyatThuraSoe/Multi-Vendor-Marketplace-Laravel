<?php
// app/Http/Resources/AnalyticsResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'period' => $this->period,
            'metrics' => [
                'revenue' => [
                    'current' => $this->revenue_current,
                    'previous' => $this->revenue_previous,
                    'growth' => $this->revenue_growth,
                    'chart_data' => $this->revenue_chart_data,
                ],
                'orders' => [
                    'current' => $this->orders_current,
                    'previous' => $this->orders_previous,
                    'growth' => $this->orders_growth,
                    'chart_data' => $this->orders_chart_data,
                ],
                'customers' => [
                    'current' => $this->customers_current,
                    'previous' => $this->customers_previous,
                    'growth' => $this->customers_growth,
                    'chart_data' => $this->customers_chart_data,
                ],
                'products' => [
                    'current' => $this->products_current,
                    'previous' => $this->products_previous,
                    'growth' => $this->products_growth,
                ],
            ],
            'top_products' => ProductListResource::collection($this->top_products),
            'top_categories' => CategoryResource::collection($this->top_categories),
            'recent_orders' => OrderResource::collection($this->recent_orders),
            'customer_segments' => $this->customer_segments,
            'geographic_data' => $this->geographic_data,
            'conversion_funnel' => $this->conversion_funnel,
        ];
    }
}
