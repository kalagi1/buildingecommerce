<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFooterLinkRequest;
use App\Http\Requests\UpdateFooterLinkRequest;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    public function index()
    {
        $footerLinks = FooterLink::orderBy('id', 'desc')->get();
        return view('admin.footer_links.index', compact('footerLinks'));
    }

    public function create()
    {
        return view('admin.footer_links.create');
    }

    public function store(CreateFooterLinkRequest $request)
    {
        FooterLink::create($request->validated());
        return redirect()->route('admin.footer_links.index')->with('success', 'Footer link created successfully.');
    }

    public function show(FooterLink $footerLink)
    {
        return view('admin.footer_links.show', compact('footerLink'));
    }

    public function edit(FooterLink $footerLink)
    {
        return view('admin.footer_links.edit', compact('footerLink'));
    }

    public function update(UpdateFooterLinkRequest $request, FooterLink $footerLink)
    {
        $footerLink->update($request->validated());
        return redirect()->route('admin.footer_links.index')->with('success', 'Footer link updated successfully.');
    }

    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();
        return redirect()->route('admin.footer_links.index')->with('success', 'Footer link deleted successfully.');
    }
}
