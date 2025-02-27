<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Html2Text\Html2Text;
use Illuminate\Support\Facades\Log;

class ToolController extends Controller
{
    public function index()
    {
        return view('tool.index');
    }

    public function CalculateAndGetDensity(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return response()->json(['error' => 'Invalid request method'], 405);
        }

        // Validate inputs
        $request->validate([
            'keywordInput' => 'required|string',
            'keyword' => 'required|string|min:1',
        ]);

        try {
            // Convert HTML to plain text and normalize
            $html = new Html2Text($request->keywordInput);
            $text = strtolower($html->getText());
            $totalWordCount = str_word_count($text);
            $wordsAndOccurrence = array_count_values(str_word_count($text, 1));

            $keywordDensityArray = [];
            $keyword = strtolower(trim($request->keyword)); // Normalize keyword

            if (!isset($wordsAndOccurrence[$keyword])) {
                Log::warning("Keyword '{$keyword}' not found.");
                return response()->json(["error" => "Keyword '{$keyword}' not found in the text"], 404);
            }

            $count = $wordsAndOccurrence[$keyword];
            $density = round(($count / $totalWordCount) * 100, 2);

            $keywordDensityArray[] = [
                "keyword" => $keyword,
                "count" => $count,
                "density" => $density
            ];

            return response()->json($keywordDensityArray);

        } catch (\Exception $e) {
            Log::error("Error in CalculateAndGetDensity: " . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}
