<?php

namespace App\Http\Controllers\API;

use App\Models\Translation;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::with('tags');

        if ($request->has('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $request->tag));
        }

        if ($request->has('key')) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        if ($request->has('content')) {
            $query->where('content', 'like', '%' . $request->content . '%');
        }

        return response()->json($query->paginate(50));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'locale' => 'required|string|in:en,fr,es',
            'key' => 'required|string|unique:translations',
            'content' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'string',
        ]);

        $translation = Translation::create([
            'locale' => $data['locale'],
            'key' => $data['key'],
            'content' => $data['content'],
        ]);

        if (!empty($data['tags'])) {
            $tagIds = collect($data['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $translation->tags()->attach($tagIds);
        }

        return response()->json($translation, 201);
    }

    public function update(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);

        $data = $request->validate([
            'locale' => 'sometimes|string|in:en,fr,es',
            'key' => 'sometimes|string|unique:translations,key,' . $id,
            'content' => 'sometimes|string',
            'tags' => 'array',
            'tags.*' => 'string',
        ]);

        $translation->update($data);

        if (isset($data['tags'])) {
            $tagIds = collect($data['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });
            $translation->tags()->sync($tagIds);
        }

        return response()->json($translation);
    }

    public function export()
    {
        $translations = Translation::with('tags')->get();

        $export = $translations->groupBy('locale')->map(function ($group) {
            return $group->mapWithKeys(fn ($item) => [$item->key => $item->content]);
        });

        return response()->json($export);
    }
}
