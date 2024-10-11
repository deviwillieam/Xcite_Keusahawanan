@extends('layouts.app')

@section('page-title', 'Startup Registration')
@section('page-heading', 'Startup Registration')

@section('breadcrumbs')
<li class="breadcrumb-item active">
    Startup Registration
</li>
@stop

@section('content')
<div class="container">
    <h1>Startup Registration</h1>

    <!-- Display success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Display error message -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Display validation errors -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="startup-registration-tab" data-toggle="tab" href="#startup-registration" role="tab" aria-controls="startup-registration" aria-selected="true">Startup Registration</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="registered-groups-tab" data-toggle="tab" href="#registered-groups" role="tab" aria-controls="registered-groups" aria-selected="false">Registered Groups</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="startup-registration" role="tabpanel" aria-labelledby="startup-registration-tab">
            <form id="student-form" action="{{ route('student-registration.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Startup Registration Section -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Startup Registration</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="group_name">Group Name</label>
                                    <input type="text" name="group_name" id="group_name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="group_email">Group Email</label>
                                    <input type="email" name="group_email" id="group_email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="brief_about">Brief About Product or Project</label>
                                    <textarea name="brief_about" id="brief_about" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="video_url">Video URL (optional)</label>
                                    <input type="url" name="video_url" id="video_url" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="video_file">Video File Upload (optional)</label>
                                    <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*">
                                </div>

                                <div class="form-group">
                                    <label for="pitchdeck_file">Pitch Deck Document (optional)</label>
                                    <input type="file" name="pitchdeck_file" id="pitchdeck_file" class="form-control" accept=".pdf,.ppt,.pptx">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Student Information Section -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Student Information</h5>
                            </div>
                            <div class="card-body">
                                <div id="student-fields">
                                    <div class="student-entry">
                                        <div class="form-group">
                                            <label for="student_name_1">Student Name (1)</label>
                                            <input type="text" name="student_name[]" id="student_name_1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student_email_1">Student Email</label>
                                            <input type="email" name="student_email[]" id="student_email_1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number_1">Phone Number</label>
                                            <input type="text" name="phone_number[]" id="phone_number_1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="course_1">Course</label>
                                            <input type="text" name="course[]" id="course_1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="year_course_1">Year of Course</label>
                                            <input type="text" name="year_course[]" id="year_course_1" class="form-control" required>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                                <button type="button" id="add-student" class="btn btn-secondary">Add Another Student</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="registered-groups" role="tabpanel" aria-labelledby="registered-groups-tab">
            <div class="row">
                @foreach($registrations as $registration)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>{{ $registration->group_name }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Email:</strong> {{ $registration->group_email }}</p>
                            <p><strong>About:</strong> {{ $registration->brief_about }}</p>
                            <button class="btn btn-info view-details" data-toggle="modal" data-target="#detailsModal"
                                data-id="{{ $registration->id }}"
                                data-name="{{ $registration->group_name }}"
                                data-email="{{ $registration->group_email }}"
                                data-about="{{ $registration->brief_about }}"
                                data-video-url="{{ $registration->video_url }}"
                                data-video-file="{{ $registration->video_file ? Storage::url($registration->video_file) : null }}"
                                data-pitchdeck-file="{{ $registration->pitchdeck_file ? Storage::url($registration->pitchdeck_file) : null }}"
                                data-members="{{ json_encode($registration->students) }}">View</button>
                            <form action="{{ route('student-registration.destroy', $registration->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Group Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-group-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Ensure this is included -->
                    <input type="hidden" name="group_id" id="modal-group-id">
                    <div class="form-group">
                        <label for="edit_group_name">Group Name</label>
                        <input type="text" name="group_name" id="edit_group_name" class="form-control" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_group_email">Group Email</label>
                        <input type="email" name="group_email" id="edit_group_email" class="form-control" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_brief_about">About</label>
                        <textarea name="brief_about" id="edit_brief_about" class="form-control" rows="3" required disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_video_url">Video URL (optional)</label>
                        <input type="url" name="video_url" id="edit_video_url" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_video_file">Upload New Video File (optional)</label>
                        <input type="file" name="video_file" id="edit_video_file" class="form-control" accept="video/*" disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_pitchdeck_file">Upload New Pitch Deck Document (optional)</label>
                        <input type="file" name="pitchdeck_file" id="edit_pitchdeck_file" class="form-control" accept=".pdf,.ppt,.pptx" disabled>
                    </div>
                    <h6>Members:</h6>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody id="modal-group-members"></tbody>
                        </table>
                    </div>
                    <h6>Files:</h6>
                    <div id="modal-group-files"></div>
                    <button type="button" class="btn btn-primary" id="edit-group-button">Edit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let studentCount = 1; // Initialize student count

    document.getElementById('add-student').addEventListener('click', function() {
        studentCount++; // Increment student count
        const studentFields = document.querySelector('.student-entry').cloneNode(true);

        // Update the labels and IDs for the new student entry
        const labels = studentFields.querySelectorAll('label');
        labels.forEach(label => {
            const newId = label.getAttribute('for').split('_')[0] + '_' + studentCount;
            label.setAttribute('for', newId);
            label.innerText = label.innerText.replace(/\(\d+\)/, `(${studentCount})`); // Update the student number
        });

        // Clear the input values for the cloned fields
        const inputs = studentFields.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = ''; // Clear the input values
            input.id = input.id.split('_')[0] + '_' + studentCount; // Update the ID
        });

        document.getElementById('student-fields').appendChild(studentFields);
    });

    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete this registration?')) {
            button.parentElement.submit();
        }
    }

    // Populate modal with group details
    $('.view-details').on('click', function() {
        const groupId = $(this).data('id');
        const groupName = $(this).data('name');
        const groupEmail = $(this).data('email');
        const groupAbout = $(this).data('about');
        const groupMembers = $(this).data('members');
        const videoUrl = $(this).data('video-url');
        const videoFile = $(this).data('video-file');
        const pitchdeckFile = $(this).data('pitchdeck-file');

        $('#modal-group-id').val(groupId); // Set the group ID for the edit form
        $('#edit_group_name').val(groupName); // Populate the edit fields
        $('#edit_group_email').val(groupEmail);
        $('#edit_brief_about').val(groupAbout);
        $('#edit_video_url').val(videoUrl); // Populate video URL

        // Populate members list
        const membersList = $('#modal-group-members');
        membersList.empty(); // Clear previous members
        groupMembers.forEach((member) => {
            membersList.append(`
                <tr>
                    <td>${member.student_name}</td>
                    <td>${member.student_email}</td>
                    <td>${member.phone_number}</td>
                    <td>${member.course}</td>
                    <td>${member.year_course}</td>
                </tr>
            `);
        });

        // Populate files section
        const filesSection = $('#modal-group-files');
        filesSection.empty(); // Clear previous files
        if (videoUrl) {
            filesSection.append(`<p><strong>Video URL:</strong> <a href="${videoUrl}" target="_blank">Watch Video</a></p>`);
        }
        if (videoFile) {
            filesSection.append(`<p><strong>Video File:</strong> <a href="${videoFile}" class="btn btn-primary" download>Download Video</a></p>`);
        }
        if (pitchdeckFile) {
            filesSection.append(`<p><strong>Pitch Deck:</strong> <a href="${pitchdeckFile}" class="btn btn-primary" download>Download Pitch Deck</a></p>`);
        }
    });

    // Enable editing in the modal
    $('#edit-group-button').on('click', function() {
        const isEditing = $(this).text() === 'Save';

        $('#edit_group_name').prop('disabled', isEditing);
        $('#edit_group_email').prop('disabled', isEditing);
        $('#edit_brief_about').prop('disabled', isEditing);
        $('#edit_video_url').prop('disabled', isEditing);
        $('#edit_video_file').prop('disabled', isEditing);
        $('#edit_pitchdeck_file').prop('disabled', isEditing);

        // Toggle member editing
        const membersInputs = $('#modal-group-members input');
        if (isEditing) {
            membersInputs.prop('disabled', true);
            $(this).text('Edit');
        } else {
            membersInputs.prop('disabled', false);
            $(this).text('Save');
        }

        // If saving, submit the form
        if (isEditing) {
            const form = $('#edit-group-form');
            form.attr('action', `/student-registration/${$('#modal-group-id').val()}`); // Update the action URL
            form.submit(); // Submit the form
        }
    });
</script>
@endsection
@endsection