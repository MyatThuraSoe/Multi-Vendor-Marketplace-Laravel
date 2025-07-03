<?php
// app/Http/Resources/SearchResultResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'products' => ProductListResource::collection($this->products),
            'categories' => CategoryResource::collection($this->categories),
            'sellers' => SellerProfileResource::collection($this->sellers),
            'filters' => [
                'categories' => $this->available_categories,
                'price_range' => $this->price_range,
                'sellers' => $this->available_sellers,
                'ratings' => $this->rating_options,
            ],
            'pagination' => [
                'current_page' => $this->products->currentPage(),
                'last_page' => $this->products->lastPage(),
                'per_page' => $this->products->perPage(),
                'total' => $this->products->total(),
                'from' => $this->products->firstItem(),
                'to' => $this->products->lastItem(),
            ],
            'sort_options' => [
                'relevance' => 'Relevance',
                'price_asc' => 'Price: Low to High',
                'price_desc' => 'Price: High to Low',
                'newest' => 'Newest First',
                'rating' => 'Highest Rated',
                'popularity' => 'Most Popular',
            ],
            'applied_filters' => $this->applied_filters,
            'search_query' => $this->search_query,
            'total_results' => $this->total_results,
            'search_suggestions' => $this->search_suggestions,
        ];
    }
}
