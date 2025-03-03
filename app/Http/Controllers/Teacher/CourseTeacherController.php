<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Teacher;

class CourseTeacherController extends Controller
{
	protected function uploadCourseImage($request) {
		$courseImage = $request->file('course_image');
		$imageName = time().$courseImage->getClientOriginalName();
		$courseImage->move(public_path('course-images'), $courseImage);
		$imageUrl = "public/tourism/course-images/$imageName";
		return $imageUrl;
	}

	// return all the courses
	public function index() {
		$teacher = Teacher::where('user_id', auth()->id())->first();
		$courses = $teacher->courses()->get();
        $students = $courses->map(function ($item){
			return $item->students()->count();
		});
		$academies = $courses->map(function($item){
			return $item->academy()->first();
		});
		$name = $academies->map(function($item) {
			return collect($item)->only('name');
		});
		for ($i = 0;$i < count($courses);$i++) {
			$courses[$i]['academy_name'] = $name[$i]['name'];
			$courses[$i]['student_number'] = $students[$i];
		}
		return response()->json([
			'status' => 200,
			'message' => 'done succeefully',
			'courses' => $courses,
		]);
		
	}
	// show specific course
	public function show(Course $course) {
		return response()->json([
			'status' => 200,
			'message' => 'course details',
			'course' => $course
		]);
	}

    // Display a list of students enrolled in a course
	public function courseStudents(Course $course) {
        //$teacher = Teacher::where('user_id', auth()->id())->first();
	    $students = $course->students()->get();
		$students = $students->map(function($item) {
			return collect($item)->only(['first_name', 'last_name', 'photo'])->all();
		});

	    return response()->json([
			'status' => 200,
			'message' => 'Students in this course',
	    	'students' => $students
	    ]);
	}
    // Remove a student from a course
	public function removeStudent(Request $request, Course $course) {
	    $validatedData = $request->validate([
	        'student_id' => 'required|exists:students,id',
	    ]);
	    $course->students()->detach($validatedData['student_id']);

	    return response()->json([
	    	'course' => $course,
	    	'success' => 'Student removed successfully'
	    ]);
	}

	public function destroy(Course $course) {
		$course->delete();
		return response()->json([
			'status' => 200,
			'message' => 'done succeefully',
			'message' => 'course deleted succfully'
		]);
	}
	public function addMarks(Request $request, Course $course) {
		$data = $request->all();
		$myArray = array($data);

		foreach ($myArray as $value) {
			foreach($value as $subKey => $subValue) {
				if ($subValue >= 0 && $subValue <= 100) {
					$mark = new Mark();
					$mark->value = $subValue;
					$mark->student_id = $subKey;
					$mark->course_id = $course->id;
					$mark->save();
				}else {
					echo ("You can't enter this value");
				}
			}
		}
		return response()->json([
			'status' => 200,
			'message' => 'marks added successfully',
			'data' => [],
		]);
	}
}
