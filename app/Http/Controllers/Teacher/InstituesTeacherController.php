<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use App\Models\AcademyTeacher;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonNotification;
use App\Models\Teacher;
use App\Models\TeacherSchedule;
use Illuminate\Http\Request;

class InstituesTeacherController extends Controller
{
    public function index() {
        $ids = AcademyTeacher::where('approved', 1)->get();
        $ids = $ids->map(function($item){
            return collect($item)->only('academy_id')->all();
        });
        $ids = $ids->map(function($item){
            return ($item['academy_id']);
        });
        $data = [];
        foreach ($ids as $id) {
            $academie = Academy::find($id)->only(['name', 'photo', 'location']);

            $data[] = $academie;
        }
        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => $data,
        ]);
    }
   
    
    public function store(Academy $id, Request $request) {
        $t_id = Teacher::where('user_id', auth()->id())->first();
        $condition = AcademyTeacher::where('teacher_id', $t_id->id)
        ->where('academy_id', $id->id)
        ->get();
        if (count($condition) !== 0)
            return response()->json([
                'status' => 200,
                'message' => 'you already request this academy',
                'data' => null
        ]);

        $order = AcademyTeacher::query()->create([
            'teacher_id' => $t_id->id,
            'academy_id' => $id->id
        ]);

        $order = TeacherSchedule::create($request->all() + ['academy_teacher_id' => $order->id]);
        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => $order,
        ]);
    }

    public function pendingRequests() {
        $t_id = Teacher::where('user_id', auth()->id())->first();
        $requests = AcademyTeacher::where('approved', 0)
        ->where('teacher_id', $t_id->id)
        ->get();
        $academies = $requests->map(function ($item) {
            $academy = Academy::find($item->academy_id)->only(['name', 'location', 'image']);
            return $academy;
        });

        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => $academies,
        ]);
    }



    public function cancelRequest(AcademyTeacher $order) {
        $order->delete();
        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => [],
        ]);
    }
    public function show(Academy $academy) {
        return $academy;
    }
    // public function show(Academy $academy) {
    //     $info = Academy::with(['photos', 'offers'])
    //     ->where('id', $academy->id)
    //     ->get();
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'successful',
    //         'data' => $info,
    //     ]);
    // }

    public function addLesson(Request $request, Course $course) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'title1' => 'required|string',
            'title2' => 'required|string',
            'title3' => 'required|string',
            'title4' => 'required|string',
            'title5' => 'required|string',
            'title6' => 'required|string',
        ]);
        $teacher = Teacher::where('user_id' , auth()->id())->first();
        $lesson = $course->lessons()->create($validatedData);
        $notification = LessonNotification::create([
            'lesson_id' => $lesson->id,
            'title' => "the teacher $teacher->first_name  $teacher->last_name add lesson to the course $course->title"
        ]);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $lesson
        ]);
    }

    public function showStudents(Course $course) {
        $students = $course->students()->get();
        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => $students,
        ]);
    }

    public function coursesHistory() {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        $allCourses = $teacher->courses()->get();
        return response()->json([
            'status' => 200,
            'message' => 'successful',
            'data' => $allCourses,
        ]);
    }

    public function showLessons(Course $course) {
        $lessons = $course->lessons()->get();
        
        return response()->json([
            'status' => 200,
            'message' => 'successful get lessons',
            'data' => $lessons,
        ]);
    }
    public function destroy(Lesson $lesson) {
        
        $lesson->delete();
        
        return response()->json([
            'status' => 200,
            'message' => 'delete it successful',
        ]);
    }
}
