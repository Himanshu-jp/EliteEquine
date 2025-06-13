<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\TermsPrivacyService;

class TermPrivacyController extends Controller
{
    protected TermsPrivacyService $termsPrivacyService;

    public function __construct(TermsPrivacyService $termsPrivacyService)
    {
        $this->termsPrivacyService = $termsPrivacyService;
    }

    public function terms()
    {
        $slug = 'terms-conditions';

        $result = $this->termsPrivacyService->getCMSPageDataBySlug($slug);

        if (!$result['success'] || empty($result['data'])) {
            abort(404, 'Page not found');
        }

        $termsData = $result['data'];

        return view('front.terms', compact('termsData'));
    }

    
    public function policy()
    {
        $slug = 'privacy-policies';

        $result = $this->termsPrivacyService->getCMSPageDataBySlug($slug);

        if (!$result['success'] || empty($result['data'])) {
            abort(404, 'Page not found');
        }

        $policyData = $result['data'];
        return view('front.privacy', compact('policyData'));
    }
}
