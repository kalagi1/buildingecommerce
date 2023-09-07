<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(CreatePageRequest $request)
    {
        $validatedData = $request->validated();

        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Page::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validatedData['slug'] = $slug;

        Page::create($validatedData);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $validatedData = $request->validated();

        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validatedData['slug'] = $slug;

        $page->update($validatedData);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
