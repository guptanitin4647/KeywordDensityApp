<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Html2Text\Html2Text;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ToolController extends Controller
{
    public function index()
    {
        return view('tool.index');
    }

    public function CalculateAndGetDensity(Request $request)
    {
        if ($request->isMethod('POST')) {
            $requestData = json_decode($request->getContent(), true);
    
            if (!$requestData || !isset($requestData['keywordInput'])) {
                return response()->json(['error' => 'Invalid input data'], 400);
            }
    
            $html = new Html2Text($requestData['keywordInput']);
            $text = strtolower($html->getText());
    
            $stopWords = ["is", "the", "was", "and", "or", "but", "to", "a", "in", "of", "on", "at", "with", "for", "as", "by", "an", "that", "this"];
    
            $wordsArray = str_word_count($text, 1);
    
            if (!empty($requestData['removeStopWords']) && $requestData['removeStopWords']) {
                $wordsArray = array_diff($wordsArray, $stopWords);
            }
    
            $totalWordCount = count($wordsArray);
            $wordsAndOccurrence = array_count_values($wordsArray);
    
            $keywordDensityArray = [];
    
            if (!empty($requestData['keywords'])) {
                $keywords = array_map('trim', $requestData['keywords']);
                foreach ($keywords as $keyword) {
                    $keyword = strtolower($keyword);
                    if (isset($wordsAndOccurrence[$keyword])) {
                        $count = $wordsAndOccurrence[$keyword];
                        $density = ($totalWordCount > 0) ? round(($count / $totalWordCount) * 100, 2) : 0;
                        $keywordDensityArray[] = [
                            "keyword" => $keyword,
                            "count" => $count,
                            "density" => $density
                        ];
                    } else {
                        $keywordDensityArray[] = [
                            "keyword" => $keyword,
                            "count" => 0,
                            "density" => 0
                        ];
                    }
                }
            } else {
                foreach ($wordsAndOccurrence as $word => $count) {
                    $density = ($totalWordCount > 0) ? round(($count / $totalWordCount) * 100, 2) : 0;
                    $keywordDensityArray[] = [
                        "keyword" => $word,
                        "count" => $count,
                        "density" => $density
                    ];
                }
            }
    
            usort($keywordDensityArray, fn($a, $b) => $b['count'] - $a['count']);
    
            session(['keywordDensityData' => $keywordDensityArray]); // Store for export

            return response()->json($keywordDensityArray);
        }
    
        return response()->json(['error' => 'Invalid request method'], 405);
    }

}