@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Keyword Density Analyzer</h2>
    <p class="text-muted text-center">Analyze the density of keywords in your HTML or plain text content.</p>
    
    <form id="keywordDensityInputForm" class="p-4 border rounded shadow-sm bg-light">
        <div class="form-group d-flex align-items-center">
            <label for="toggleMode" class="mr-2">Keyword Density Mode</label>
            <input type="checkbox" id="toggleMode" checked class="ml-2">
        </div>
        <div class="form-group">
            <label for="keywordDensityInput">HTML or Text</label>
            <textarea class="form-control" id="keywordDensityInput" name="keywordInput" rows="8" placeholder="Enter HTML or plain text here..."></textarea>
        </div>
        <div class="form-group" id="keywordField">
            <label for="keyword">Keyword(s)</label>
            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword(s), separated by commas...">
        </div>
        <div class="form-group">
            <label for="stopWords">Remove Stop Words</label>
            <input type="checkbox" id="stopWords">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Get Keyword Densities</button>
    </form>
    <div id="result" class="mt-4"></div>
</div>
@endsection

@section('scripts')
<script>
function generateChart(data) {
    let ctx = document.getElementById('keywordChart').getContext('2d');
    
    if (window.keywordChartInstance) {
        window.keywordChartInstance.destroy();
    }
    
    let labels = data.map(item => item.keyword);
    let values = data.map(item => item.density);
    let backgroundColors = labels.map((_, index) => `hsl(${index * 50 % 360}, 70%, 60%)`);
    let borderColors = labels.map((_, index) => `hsl(${index * 50 % 360}, 90%, 40%)`);
    
    window.keywordChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Keyword Density (%)',
                data: values,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

document.getElementById('toggleMode').addEventListener('change', function () {
    let keywordField = document.getElementById('keywordField');
    keywordField.style.display = this.checked ? 'block' : 'none';
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
