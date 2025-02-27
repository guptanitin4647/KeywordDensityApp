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
        if ($request->isMethod('POST')) {
            // Decode JSON input
            $requestData = json_decode($request->getContent(), true);
    
            // Validate input
            if (!$requestData || !isset($requestData['keywordInput'])) {
                return response()->json(['error' => 'Invalid input data'], 400);
            }
    
            $html = new Html2Text($requestData['keywordInput']);
            $text = strtolower($html->getText());
    
            // Get total word count
            $totalWordCount = str_word_count($text);
            $wordsAndOccurrence = array_count_values(str_word_count($text, 1));
    
            $keywordDensityArray = [];
    
            // Check if full text mode is enabled
            if (isset($requestData['fullTextMode']) && $requestData['fullTextMode']) {
                // Return density for all words
                foreach ($wordsAndOccurrence as $word => $count) {
                    $density = round(($count / $totalWordCount) * 100, 2);
                    $keywordDensityArray[] = [
                        "keyword" => $word,
                        "count" => $count,
                        "density" => $density
                    ];
                }
            } else {
                // Return density only for the specific keyword
                if (!isset($requestData['keyword']) || empty(trim($requestData['keyword']))) {
                    return response()->json(['error' => 'Keyword is required in keyword mode'], 400);
                }
    
                $keyword = strtolower(trim($requestData['keyword']));
    
                if (isset($wordsAndOccurrence[$keyword])) {
                    $count = $wordsAndOccurrence[$keyword];
                    $density = round(($count / $totalWordCount) * 100, 2);
    
                    $keywordDensityArray[] = [
                        "keyword" => $keyword,
                        "count" => $count,
                        "density" => $density
                    ];
                }
            }
    
            // Sort words by occurrence in descending order
            usort($keywordDensityArray, fn($a, $b) => $b['count'] - $a['count']);
    
            return response()->json($keywordDensityArray);
        }
    
        return response()->json(['error' => 'Invalid request method'], 405);
    }
    
}
