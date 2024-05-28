<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultMessage;
use Illuminate\Http\Request;

class ReasonManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $defaultMessages = DefaultMessage::all();
        return view('admin.reason_management.index', ['templates' => $defaultMessages]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reason_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
  
        // Yeni DefaultMessage öğesini oluşturun ve veritabanına kaydedin
        $defaultMessage = new DefaultMessage();
        $defaultMessage->title = $validatedData['title'];
        $defaultMessage->content = $validatedData['content'];
        $defaultMessage->save();
    
        if ($request->input('redirectUrl')) {
            return redirect($request->input('redirectUrl'))->with('success', 'Şablon başarıyla oluşturuldu.');
        } 
            // Başarılı oluşturma mesajını göstermek için bir geri dönüş yapabilirsiniz
        return redirect()->route('admin.reason.templates.index')->with('success', 'Şablon başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DefaultMessage $defaultMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefaultMessage $defaultMessage)
    {
        return view('admin.reason_management.edit', ['template' => $defaultMessage]);   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DefaultMessage $defaultMessage)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    
        // DefaultMessage öğesinin verilerini güncelleyin
        $defaultMessage->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            // Diğer alanları da burada güncelleyebilirsiniz
        ]);
    
        // Başarılı güncelleme mesajını göstermek için bir geri dönüş yapabilirsiniz
        return redirect()->route('admin.reason.templates.index')->with('success', 'Şablon başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefaultMessage $defaultMessage)
    {
        $defaultMessage->delete();
        // Başarılı silme mesajını göstermek için bir geri dönüş yapabilirsiniz
        return redirect()->back()->with('success', 'Şablon başarıyla silindi.');
    }
}
