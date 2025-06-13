<?php

namespace App\Services\API\v1;

use App\Models\ContactUs;

class ContactUsService
{
    public function saveContact(array $data): array
    {
        try {
            $contact = ContactUs::create($data);

            return [
                'success' => true,
                'data' => $contact,
                'code' => 200
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to submit contact message. '.$e->getMessage(),
            'code' => 500
            ];
        }
    }
    
    public function getEnquiries(array $filters = [])
    {
        $query = ContactUs::with('user')->orderBy('id', 'desc');

        // Optional filter by user ID
        if (!empty($filters['user_id'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('id', $filters['user_id']);
            });
        }

        // Optional search by name, email or subject
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                ->orWhere('subject', 'like', '%' . $filters['search'] . '%');
            });
        }

        return$query = $query->paginate(10);
        /* if ($query->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No enquiry found.',
                'code'    => 200
            ];
        }

        return [
            'success' => true,
            'data'    => $query,
            'code'    => 200
        ]; */
    }

    public function delete(int $id): void
    {
        $contactUs = ContactUs::findOrFail($id);
        $contactUs->delete();
    }

    public function restore(int $id): void
    {
        ContactUs::withTrashed()->findOrFail($id)->restore();
    }

}
