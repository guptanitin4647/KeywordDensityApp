@extends('layouts.master')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4">Keyword Density Analyzer</h1>
    <p class="lead">Analyze keyword frequency in text or HTML for SEO optimization and content analysis.</p>
    
    <div class="row mt-4">
        <div class="col-md-6 mx-auto">
            <h3>How It Works</h3>
            <ol class="text-left">
                <li>Enter text or HTML in the input field.</li>
                <li>Toggle between <strong>keyword mode</strong> and <strong>full-text mode</strong>.</li>
                <li>In keyword mode, enter a keyword to analyze.</li>
                <li>Click <strong>Get Keyword Densities</strong> to process the data.</li>
                <li>View results in a table showing keyword count and density.</li>
            </ol>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Features</h3>
            <ul class="text-left">
                <li>Supports both HTML and plain text.</li>
                <li>Analyze a specific keyword or all words in the text.</li>
                <li>Interactive and user-friendly interface.</li>
                <li>Helps with SEO and content writing.</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Use Cases</h3>
            <ul class="text-left">
                <li><strong>SEO Optimization</strong> – Improve rankings by optimizing keyword usage.</li>
                <li><strong>Content Writing</strong> – Avoid overusing or underusing words.</li>
                <li><strong>Academic Research</strong> – Analyze word frequency in papers or essays.</li>
            </ul>
        </div>
    </div>

    <div class="mt-5">
        <a href="{{ route('KDTool') }}" class="btn btn-primary btn-lg">Start Analyzing</a>
    </div>
</div>
@endsection
