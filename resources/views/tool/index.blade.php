@extends('layouts.master')

@section('content')
<form id="keywordDensityInputForm">
    <div class="form-group">
        <label for="keywordDensityInput">HTML or Text</label>
        <textarea class="form-control" id="keywordDensityInput" name="keywordInput" rows="6" placeholder="Enter HTML or plain text here..."></textarea>
    </div>
    <div class="form-group">
        <label for="keyword">Keyword</label>
        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword...">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Get Keyword Density</button>
</form>

<div id="result" class="mt-3"></div>
@endsection

@section('scripts')
<script>
document.getElementById('keywordDensityInputForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let kdInput = document.getElementById('keywordDensityInput').value;
    let keyword = document.getElementById('keyword').value;

    if (kdInput.trim() === "" || keyword.trim() === "") { 
        document.getElementById('result').innerHTML = "<div class='alert alert-warning'>Please enter both text and a keyword.</div>";
        return;
    }

    fetch('/tool/calculate-and-get-density', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ keywordInput: kdInput, keyword: keyword })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            document.getElementById('result').innerHTML = `<div class='alert alert-danger'>${data.error}</div>`;
            return;
        }

        let html = `<table class='table'>
                        <thead><tr><th>Keyword</th><th>Count</th><th>Density (%)</th></tr></thead><tbody>
                        <tr><td>${data[0].keyword}</td><td>${data[0].count}</td><td>${data[0].density}%</td></tr>
                        </tbody></table>`;
        document.getElementById('result').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('result').innerHTML = `<div class='alert alert-danger'>An error occurred. Please try again.</div>`;
    });
});
</script>
@endsection
