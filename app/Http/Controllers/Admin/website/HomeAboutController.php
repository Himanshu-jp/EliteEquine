<?php

namespace App\Http\Controllers\Admin\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\website\HomeAboutRequest;
use App\Models\HomeAbout;
use App\Services\Admin\website\HomeAboutService;

class HomeAboutController extends Controller
{
    protected $aboutService;

    public function __construct(HomeAboutService $aboutService)
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
        return view('admin.website_manage.home.about.create');
    }

    public function store(HomeAboutRequest $request)
    {
        $data = $request->validated();
        $this->aboutService->create($data);
        return redirect()->route('home_about.show')->with('success', 'Home About content created successfully.');
    }

    public function edit($id)
    {
        $about = $this->aboutService->find($id);
        return view('admin.website_manage.home.about.edit', compact('about'));
    }

    public function show()
    {
        $about = HomeAbout::first(); 
        return view('admin.website_manage.home.about.show', compact('about'));
    }

    public function update(HomeAboutRequest $request, HomeAbout $homeAbout)
    {
        $data = $request->validated();
        
        $this->aboutService->update($homeAbout, $data);

        return redirect()->route('home_about.show')->with('success', 'Home About content updated successfully.');
    }

    /* public function destroy($id)
    {
        $this->aboutService->delete($id);
        return redirect()->route('home_about.index')->with('success', 'Home About content deleted successfully.');
    } */
}
