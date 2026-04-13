<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Sppg;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('sppg')->latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        $sppgs = Sppg::all();
        return view('news.create', compact('sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'sppg_id'    => 'nullable|exists:sppgs,id',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        News::create([
            'title'        => $validated['title'],
            'url'          => Str::slug($validated['title']) . '-' . rand(1000, 9999),
            'content'      => $validated['content'],
            'sppg_id'      => $validated['sppg_id'],
            'image_path'   => $imagePath,
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit(News $news)
    {
        $sppgs = Sppg::all();
        return view('news.edit', compact('news', 'sppgs'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'sppg_id'    => 'nullable|exists:sppgs,id',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->update([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'sppg_id'      => $validated['sppg_id'],
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
