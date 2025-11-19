<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bangladesh Geo Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">বাংলাদেশের Division → District → Thana → Union</h2>
    <div class="card p-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Division</label>
                <select id="division" class="form-select">
                    <option value="">-- Select Division --</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">District</label>
                <select id="district" class="form-select" disabled>
                    <option value="">-- Select District --</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Thana</label>
                <select id="thana" class="form-select" disabled>
                    <option value="">-- Select Thana --</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Union</label>
                <select id="union" class="form-select" disabled>
                    <option value="">-- Select Union --</option>
                </select>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button id="showResult" class="btn btn-primary" disabled>Show Selection</button>
        </div>
    </div>
    <!-- output -->
    <div id="resultBox" class="alert alert-info mt-4 d-none">
        <h5>আপনি যা নির্বাচন করেছেন:</h5>
        <p id="resultText" class="mb-0"></p>
    </div>
</div>

<script>
   
    const division = document.getElementById('division');
    const district = document.getElementById('district');
    const thana = document.getElementById('thana');
    const union = document.getElementById('union');
    const showResult = document.getElementById('showResult');
    const resultBox = document.getElementById('resultBox');
    const resultText = document.getElementById('resultText');


    division.addEventListener('change', function () {
        resetDropdowns(['district','thana','union']);
        if (!this.value) return;

        fetch(`/get-districts/${this.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(d => district.innerHTML += `<option value="${d.id}">${d.name}</option>`);
                district.disabled = false;
            });
    });


    district.addEventListener('change', function () {
        resetDropdowns(['thana','union']);
        if (!this.value) return;

        fetch(`/get-thanas/${this.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(t => thana.innerHTML += `<option value="${t.id}">${t.name}</option>`);
                thana.disabled = false;
            });
    });

    thana.addEventListener('change', function () {
        resetDropdowns(['union']);
        if (!this.value) return;

        fetch(`/get-unions/${this.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(u => union.innerHTML += `<option value="${u.id}">${u.name}</option>`);
                union.disabled = false;
            });
    });


    union.addEventListener('change', function () {
        showResult.disabled = !this.value;
    });

    showResult.addEventListener('click', function () {
        const divText = division.options[division.selectedIndex].text;
        const disText = district.options[district.selectedIndex]?.text || '';
        const thanaText = thana.options[thana.selectedIndex]?.text || '';
        const unionText = union.options[union.selectedIndex]?.text || '';

        resultText.innerHTML = `
            <strong>Division:</strong> ${divText} <br>
            <strong>District:</strong> ${disText} <br>
            <strong>Thana:</strong> ${thanaText} <br>
            <strong>Union:</strong> ${unionText}
        `;
        resultBox.classList.remove('d-none');
    });

    function resetDropdowns(ids) {
        ids.forEach(id => {
            const el = document.getElementById(id);
            el.innerHTML = `<option value="">-- Select ${id.charAt(0).toUpperCase() + id.slice(1)} --</option>`;
            el.disabled = true;
        });
        showResult.disabled = true;
        resultBox.classList.add('d-none');
    }
</script>

</body>
</html>
