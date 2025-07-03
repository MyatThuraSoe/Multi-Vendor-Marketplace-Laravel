<?php
// app/Http/Resources/DashboardResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'stats' => $this->stats,
            'recent_activities' => $this->recent_activities,
            'notifications' => $this->notifications,
        ];
    }
}
