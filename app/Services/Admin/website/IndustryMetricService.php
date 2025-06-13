<?php

namespace App\Services\Admin\website;

use App\Models\IndustryMatric;
use Illuminate\Support\Facades\Storage;

class IndustryMetricService
{
    // Create new metric
    public function create(array $data): IndustryMatric
    {
        if (isset($data['icon'])) {
            $data['image'] = $data['icon']->store('industry_matric', 'public');
        }

        return IndustryMatric::create($data);
    }

    // Find metric by ID
    public function find(int $id): ?IndustryMatric
    {
        return IndustryMatric::findOrFail($id);
    }

    // Update existing metric
    public function update(IndustryMatric $industryMetric, array $data): IndustryMatric
    {
        if (isset($data['icon'])) {
            if ($industryMetric->image) {
                Storage::disk('public')->delete($industryMetric->image);
            }
            $data['image'] = $data['icon']->store('industry_matric', 'public');
        }
        
        $industryMetric->update($data);

        return $industryMetric;
    }

    // Soft delete or permanently delete metric
    public function delete(int $id): void
    {
        $metric = $this->find($id);

        // Delete icon file if exists
        $this->deleteIconFile($metric->image);

        $metric->delete();
    }

    // Delete icon file from storage
    protected function deleteIconFile(?string $iconPath): void
    {
        if ($iconPath && Storage::disk('public')->exists($iconPath)) {
            Storage::disk('public')->delete($iconPath);
        }
    }

    // Delete icon only (remove icon from metric and delete file)
    public function deleteIcon(int $id): void
    {
        $metric = $this->find($id);

        $this->deleteIconFile($metric->icon);

        $metric->icon = null;
        $metric->save();
    }

    // Upload icon and return stored path
    protected function uploadIcon($iconFile): string
    {
        return $iconFile->store('industry_metrics/icons', 'public');
    }
}
