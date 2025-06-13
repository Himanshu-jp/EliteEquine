<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\IndustryMetricRequest;
use App\Models\IndustryMatric;
use App\Services\Admin\website\IndustryMetricService;

class IndustryMetricController extends Controller
{
    protected $metricService;

    // Inject IndustryMetricService
    public function __construct(IndustryMetricService $metricService)
    {
        $this->metricService = $metricService;
    }

    // Show list of industry metrics
    public function index()
    {
        $industryMetrics = IndustryMatric::orderBy('id', 'desc')->paginate(10);
        return view('admin.website_manage.home.industry_metrics.index', compact('industryMetrics'));
    }

    // Show form to create a new metric
    public function create()
    {
        return view('admin.website_manage.home.industry_metrics.create');
    }

    // Store new industry metric
    public function store(IndustryMetricRequest $request)
    {
        $data = $request->validated();
        $this->metricService->create($data);
        return redirect()->route('industry_metrics.index')->with('success', 'Industry Metric created successfully.');
    }

    // Edit an existing metric
    public function edit($id)
    {
        $metric = $this->metricService->find($id);
        return view('admin.website_manage.home.industry_metrics.edit', compact('metric'));
    }

    // View a specific metric
    public function show($id)
    {
        $industryMetric = $this->metricService->find($id);
        return view('admin.website_manage.home.industry_metrics.show', compact('industryMetric'));
    }

    // Update existing metric
    public function update(IndustryMetricRequest $request, IndustryMatric $industryMetric)
    {
        $data = $request->validated();
        $this->metricService->update($industryMetric, $data);
        return redirect()->route('industry_metrics.index')->with('success', 'Industry Metric updated successfully.');
    }

    // Delete metric (soft delete or permanent, based on service logic)
    public function destroy($id)
    {
        $this->metricService->delete($id);
        return redirect()->route('industry_metrics.index')->with('success', 'Industry Metric deleted successfully.');
    }

    // Delete metric icon/image
    /* public function deleteIcon($id)
    {
        $this->metricService->deleteIcon($id);
        return back()->with('success', 'Icon deleted successfully.');
    } */
}
