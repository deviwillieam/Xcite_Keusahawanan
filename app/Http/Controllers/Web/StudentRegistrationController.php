<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\Group;
use Vanguard\Models\Student;
use Illuminate\Http\Request;

class StudentRegistrationController extends Controller
{
    public function index()
    {
        // Fetch only the groups associated with the authenticated user
        $registrations = Group::with('students')->where('user_id', auth()->id())->get();

        // Load the appropriate view for displaying the form and groups
        return view('user.StudentRegistration', compact('registrations'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_email' => 'required|email|max:255',
            'brief_about' => 'required|string|max:1000',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:2048',
            'pitchdeck_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:2048',
            'student_name.*' => 'required|string|max:255',
            'student_email.*' => 'required|email|max:255',
            'phone_number.*' => 'required|string|max:15',
            'course.*' => 'required|string|max:255',
            'year_course.*' => 'required|string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('video_file')) {
            $validatedData['video_file'] = $this->handleFileUpload($request->file('video_file'), 'videos');
        }

        if ($request->hasFile('pitchdeck_file')) {
            $validatedData['pitchdeck_file'] = $this->handleFileUpload($request->file('pitchdeck_file'), 'pitchdecks');
        }

        // Create a new group and associate it with the authenticated user
        $group = Group::create(array_merge($validatedData, ['user_id' => auth()->id()]));

        // Create a new student record for each student entry
        foreach ($request->student_name as $index => $name) {
            Student::create([
                'group_id' => $group->id, // Associate the student with the group
                'student_name' => $name,
                'student_email' => $request->student_email[$index],
                'phone_number' => $request->phone_number[$index],
                'course' => $request->course[$index],
                'year_course' => $request->year_course[$index],
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('student-registration.index')->with('success', 'Students registered successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_email' => 'required|email|max:255',
            'brief_about' => 'required|string|max:1000',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:2048',
            'pitchdeck_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:2048',
        ]);

        // Find the group by ID
        $group = Group::findOrFail($id);

        // Ensure the group belongs to the authenticated user
        if ($group->user_id !== auth()->id()) {
            return redirect()->route('student-registration.index')->with('error', 'Unauthorized action.');
        }

        // Handle file uploads if provided
        if ($request->hasFile('video_file')) {
            $validatedData['video_file'] = $this->handleFileUpload($request->file('video_file'), 'videos');
        }

        if ($request->hasFile('pitchdeck_file')) {
            $validatedData['pitchdeck_file'] = $this->handleFileUpload($request->file('pitchdeck_file'), 'pitchdecks');
        }

        // Update the group with validated data
        $group->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('student-registration.index')->with('success', 'Group updated successfully!');
    }

    public function destroy($id)
    {
        // Find the group by ID
        $group = Group::findOrFail($id);

        // Ensure the group belongs to the authenticated user
        if ($group->user_id !== auth()->id()) {
            return redirect()->route('student-registration.index')->with('error', 'Unauthorized action.');
        }

        // Delete associated students if necessary
        $group->students()->delete();
        // Delete the group
        $group->delete();

        // Redirect back with a success message
        return redirect()->route('student-registration.index')->with('success', 'Registration deleted successfully!');
    }

    private function handleFileUpload($file, $folder)
    {
        // Handle file upload logic here (e.g., storing the file and returning its path)
        return $file->store($folder, 'public');
    }
}
