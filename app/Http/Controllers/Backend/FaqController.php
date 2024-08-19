<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('backend.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('backend.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create($request->all());

        return redirect()->route('faqs')->with('success', 'Soru başarıyla eklendi.');
    }

    public function edit(Faq $faq)
    {
        return view('backend.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update($request->all());

        return redirect()->route('faqs')->with('success', 'Soru başarıyla güncellendi.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs')->with('success', 'Soru başarıyla silindi.');
    }

    public function status(Faq $faq)
    {
        $faq->is_active = !$faq->is_active;
        $faq->save();

        return redirect()->route('faqs')->with('success', 'Soru durumu başarıyla güncellendi.');
    }


}
