<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\AboutRequest;
use App\Models\About;
use App\Services\Admin\website\AboutService;

class AboutController extends Controller
{
   protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    /* public function index()
    {
        $items = HomeAbout::orderBy('id', 'desc')->paginate(10);
        return view('admin.website_manage.home.about.index', compact('items'));
    } */

    public function create()
    {
        return view('admin.website_manage.about_us.about.create');
    }

    public function store(AboutRequest $request)
    {
        $data = $request->validated();
        $this->aboutService->create($data);
        return redirect()->route('about.show')->with('success', 'About content created successfully.');
    }

    public function edit($id)
    {
        $about = $this->aboutService->find($id);
        return view('admin.website_manage.about_us.about.edit', compact('about'));
    }

    public function show()
    {
        $about = About::first(); 
        return view('admin.website_manage.about_us.about.show', compact('about'));
    }

    public function update(AboutRequest $request, About $about)
    {
        $data = $request->validated();
        
        $this->aboutService->update($about, $data);

        return redirect()->route('about.show')->with('success', 'About content updated successfully.');
    }

    /* public function destroy($id)
    {
        $this->aboutService->delete($id);
        return redirect()->route('about.index')->with('success', 'About content deleted successfully.');
    } */
}
