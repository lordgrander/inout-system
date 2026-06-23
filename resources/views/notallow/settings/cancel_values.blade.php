<div class="container">
    <div class="row mb-4">
        <div class="col-md-3">
            <select id="monthSelect" class="form-control">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                        <!-- {{ date('F', mktime(0, 0, 0, $m, 1)) }} -->
                        {{$m }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="yearSelect" class="form-control">
                @foreach(range(2025, 2030) as $y)
                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Cancel Value</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadTable() {
        let month = $('#monthSelect').val();
        let year = $('#yearSelect').val();
        
        $.get("{{ route('doc.cancel.fetch') }}", { month: month, year: year }, function(data) {
            $('#tableBody').html(data.html);
        });
    }

    // Load on page start
    loadTable();

    // Reload when select changes
    $('#monthSelect, #yearSelect').on('change', loadTable);

    // Save data on change
    $(document).on('change', '.ajax-update', function() {
        let date = $(this).data('date');
        let value = $(this).val();

        $.post("{{ route('doc.cancel.update') }}", {
            _token: "{{ csrf_token() }}",
            date: date,
            value: value
        }, function(response) {
            console.log('Saved!');
            // You can add a small toast notification here
        });
    });
});
</script>