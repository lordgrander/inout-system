<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkDownController extends Controller
{
    public function index()
    {
        $select_markdown = \App\Models\BetaMarkdown::all();
        return view('notallow.markdown.index', compact('select_markdown'));
    }

    public function store_markdown(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        // Create a new BetaMarkdown entry
        $markdown = new \App\Models\BetaMarkdown();
        $markdown->name = $request->input('name');
        $markdown->detail = $request->input('detail');
        $markdown->save();

        // Redirect back with a success message
        return response()->json(['message' => 'Markdown entry created successfully', 'id' => $markdown->id], 201);
    }

    public function delete_markdown(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer|exists:beta_markdown,id',
        ]);

        // Find the BetaMarkdown entry by ID and delete it
        $markdown = \App\Models\BetaMarkdown::find($request->input('id'));
        if ($markdown) {
            $markdown->delete();
            return response()->json(['message' => 'Markdown entry deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Markdown entry not found'], 404);
        } 
    }

    public function update_markdown(Request $request)
    {
        dd(1);
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer|exists:beta_markdown,id',
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        // Find the BetaMarkdown entry by ID and update it
        $markdown = \App\Models\BetaMarkdown::find($request->input('id'));
        if ($markdown) {
            $markdown->name = $request->input('name');
            $markdown->detail = $request->input('detail');
            $markdown->save();
            return response()->json(['message' => 'Markdown entry updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Markdown entry not found'], 404);
        }
    }
}
