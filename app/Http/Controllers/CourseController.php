<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function seeCourse()
    {
        // implement see course action or other bussiness logic
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function donwloadCourse()
    {
        // implement download course action or other bussiness logic
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function sendDirectMessageToMentor()
    {
        // implement send direct message action or other bussiness logic
        return response()->json([
            'message' => 'success'
        ]);
    }
}
