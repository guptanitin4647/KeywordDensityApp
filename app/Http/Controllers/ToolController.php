<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Html2Text\Html2Text;

class ToolController extends Controller
{
    public function index()
    {
        return view('tool.index');
    }

    public function CalculateAndGetDensity(Request $request) {
        // Check if the request method is POST
        if ($request->isMethod('POST')) {
            // Validate the input
            $request->validate([
                'keywordInput' => 'required|string',
                'keyword' => 'required|string|min:1',
            ]);

            // Convert HTML to plain text
            $html = new Html2Text($request->keywordInput);
            $text = strtolower($html->getText()); // Convert to lower case

            // Get total word count
            $totalWordCount = str_word_count($text);
            // Get each word and the occurrence count as key-value array
            $wordsAndOccurrence = array_count_values(str_word_count($text, 1));
            arsort($wordsAndOccurrence); // Sort into descending order of occurrence

            $keywordDensityArray = [];
            // Build the array
            foreach ($wordsAndOccurrence as $key => $value) {
                $keywordDensityArray[] = [
                    "keyword" => $key, // keyword
                    "count" => $value, // word occurrences
                    "density" => round(($value / $totalWordCount) * 100, 2) // Round density to two decimal places
                ];
            }

            // Return the result as JSON
            return response()->json($keywordDensityArray);
        }

        // If the method is not POST, return an error response
        return response()->json(['error' => 'Invalid request method'], 405);
    }
}