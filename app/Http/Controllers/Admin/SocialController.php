<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SocialLinkRequest;
use App\Services\Admin\SocialLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialController extends Controller
{
    protected $service;

    public function __construct(SocialLinkService $service)
    {
        $this->service = $service;
    }

    public function edit(): View
    {
        $social = $this->service->get();
        return view('admin.website_manage.social_links.edit', compact('social'));
    }

    public function update(SocialLinkRequest $request): RedirectResponse
    {
        $this->service->update($request->validated());

        return redirect()->back()->with('success', 'Social links updated successfully.');
    }
}
