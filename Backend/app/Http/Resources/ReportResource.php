<?php
// app/Http/Resources/ReportResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'report_type' => $this->report_type,
            'period' => $this->period,
            'generated_at' => $this->generated_at,
            'summary' => $this->summary,
            'data' => $this->data,
            'charts' => $this->charts,
            'export_formats' => ['pdf', 'excel', 'csv'],
            'filters_applied' => $this->filters_applied,
            'total_records' => $this->total_records,
        ];
    }
}
