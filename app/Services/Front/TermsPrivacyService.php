<?php
namespace App\Services\Front;

use App\Models\CMSPage;

class TermsPrivacyService
{
    // terms-condition and privacy-policy web page data
    public function getCMSPageDataBySlug($slug): array
    {
        $cmsPageData = CMSPage::where('slug', $slug)->orderBy('id', 'asc')->first();
        if(!empty($cmsPageData))
        {
            return [
                'success' => true,
                'message' => 'successfully',
                'data' => $cmsPageData
            ];
        }
        
        return [
            'success' => false,
            'message' => 'This page has not exised.',
            'data' => []
        ];
    }
}