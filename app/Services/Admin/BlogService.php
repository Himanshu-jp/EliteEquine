<?php
namespace App\Services\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public function createBlog($data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('blogs', 'public');
        }
        $blog = Blog::create($data);
        return $blog;
    }

    public function updateBlog(Blog $blog, array $data)
    {
        // Check if title has changed and regenerate unique slug
        if ($data['title'] !== $blog->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $blog->id);
        } else {
            $data['slug'] = $blog->slug;
        }

        // Handle image update
        if (isset($data['image'])) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $data['image'] = $data['image']->store('blogs', 'public');
        }

        $blog->update($data);

        return $blog;
    }


    protected function generateUniqueSlug(string $title, $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Blog::where('slug', $slug)
                ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function delete(Blog $blog): void
    {
        $blog->delete();
    }

    public function restore(int $id): void
    {
        Blog::withTrashed()->findOrFail($id)->restore();
    }
}
