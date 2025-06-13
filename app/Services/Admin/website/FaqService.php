<?php

namespace App\Services\Admin\website;

use App\Models\BuyerFaq;
use Illuminate\Support\Facades\Storage;

class FaqService
{
    /**
     * Store a newly created FAQ.
     */
    public function store(array $data): BuyerFaq
    {
        return BuyerFaq::create(['questions' => $data['question'], 'answers' => $data['answer']]);
    }

    /**
     * Update the given FAQ.
     */
    public function update(BuyerFaq $faq, array $data): bool
    {
        return $faq->update(['questions' => $data['question'], 'answers' => $data['answer']]);
    }

    /**
     * Soft delete the given FAQ.
     */
    public function delete(BuyerFaq $faq): ?bool
    {
        return $faq->delete();
    }

    /**
     * Restore a soft-deleted FAQ.
     */
    public function restore(int $id): bool
    {
        $faq = BuyerFaq::withTrashed()->findOrFail($id);
        return $faq->restore();
    }
}
