<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:email_templates',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $template = new EmailTemplate();
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->body = $request->input('body');
        $template->slug = Str::slug($request->input('name'));
        $template->save();

        return redirect()->route('admin.email-templates.index');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email-templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('email_templates')->ignore($id),
            ],
            'subject' => 'required',
            'body' => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->body = $request->input('body');
        $template->slug = Str::slug($request->input('name'));
        $template->save();

        return redirect()->route('admin.email-templates.index');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();
        return redirect()->route('admin.email-templates.index');
    }
}
