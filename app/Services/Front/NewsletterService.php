<?php
namespace App\Services\Front;

use App\Models\Newsletter;

class NewsletterService
{
    public function subscribe(string $email): Newsletter
    {
        return Newsletter::create(['email' => $email]);
    }

    public function newsletterList(array $filter = [])
    {
        $query = Newsletter::query();

        if (!empty($filter['search'])) {
            $query->where('email', 'like', '%' . $filter['search'] . '%');
        }

        return $query->orderBy('id', 'desc')->paginate(10);
    }

    public function delete(int $id): void
    {
        $contactUs = Newsletter::findOrFail($id);
        $contactUs->delete();
    }

    public function restore(int $id): void
    {
        Newsletter::withTrashed()->findOrFail($id)->restore();
    }
}
