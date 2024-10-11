@extends('layouts.app')

@section('page-title', 'List of Startups')
@section('page-heading', 'List of Startups')

@section('breadcrumbs')
<li class="breadcrumb-item active">
    List of Startups
</li>
@stop

@section('content')
<div class="container">
    <!-- Card to wrap the content -->
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">List of Startups</h1>

            <!-- Search Input -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for anything..." onkeyup="searchTable()">
            </div>

            <!-- Print Button -->
            <button class="btn btn-primary mb-3" onclick="printTable()">Print Table</button>

            <!-- Table Section -->
            <table class="table table-bordered" id="groupTable">
                <thead>
                    <tr>
                        <th>No</th> <!-- Column for index -->
                        <th>User Name</th> <!-- Column for User Name -->
                        <th>Group Name</th>
                        <th>Group Email</th>
                        <th>Brief About</th>
                        <th>Video Link</th> <!-- Column for Video Link -->
                        <th>Pitch Deck</th> <!-- Column for Pitch Deck -->
                        <th>Students</th>
                    </tr>
                </thead>
                <tbody>
                    @if($registrations->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No groups found.</td>
                    </tr>
                    @else
                    @foreach($registrations as $index => $group)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Display the index + 1 -->
                        <td>{{ $group->user->username ?? 'N/A' }}</td> <!-- Display User Name -->
                        <td>{{ $group->group_name }}</td>
                        <td>{{ $group->group_email }}</td>
                        <td>{{ $group->brief_about }}</td>
                        <td>
                            @if($group->video_url)
                            <a href="{{ $group->video_url }}" target="_blank">Watch Video</a>
                            @else
                            No video available
                            @endif
                        </td>
                        <td>
                            @if($group->pitchdeck_file)
                            <a href="{{ asset('storage/pitchdecks/' . $group->pitchdeck_file) }}" download>Download Pitch Deck</a>
                            @else
                            No pitch deck available
                            @endif
                        </td>
                        <td>
                            @if($group->students->isEmpty())
                            No students enrolled
                            @else
                            <ul>
                                @foreach($group->students as $student)
                                <li>
                                    <strong>Name:</strong> {{ $student->student_name }}<br>
                                    <strong>Email:</strong> {{ $student->student_email }}<br>
                                    <strong>Phone:</strong> {{ $student->phone_number }}<br>
                                    <strong>Course:</strong> {{ $student->course }}<br>
                                    <strong>Year:</strong> {{ $student->year_course }}<br>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('groupTable');
        const tr = table.getElementsByTagName('tr');

        // Loop through all table rows, except the first (header row)
        for (let i = 1; i < tr.length; i++) {
            let found = false;
            const td = tr[i].getElementsByTagName('td');

            // Loop through all cells in the row
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    const txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching in this row if a match is found
                    }
                }
            }

            // Show or hide the row based on the search result
            tr[i].style.display = found ? "" : "none";
        }
    }

    function printTable() {
        const printContents = document.getElementById('groupTable').outerHTML;
        const newWindow = window.open('', '', 'height=600,width=800');
        newWindow.document.write('<html><head><title>Print Table</title>');
        newWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
        newWindow.document.write('</head><body>');
        newWindow.document.write(printContents);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.print();
    }
</script>
@endsection