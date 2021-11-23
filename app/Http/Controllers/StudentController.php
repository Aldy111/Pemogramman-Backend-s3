<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{

    public function index()
    {
        $data = Student::all();

        return response()->json($data, 200);
    }

    public function create(Request $request)
    {
        //menerima data requst dari body

        $validated = $request->validate([
            "nama" => "required",
            "nim" => "required|numeric",
            "email" => "required|email",
            "jurusan" => "required"
        ]);

        $student = Student::create($validated);



        //jika ingin memangil tanpa membuat variable
        // $student = Student::create(
        //     [
        //         //insert data ke database->Student
        //         'nama' => $request->nama,
        //         'nim' => $request->nim,
        //         'email' => $request->email,
        //         'jurusan' => $request->jurusan
        //     ]
        // );

        $data = [
            'message' => 'Student is Created Successfully',
            'data' => $student
        ];
        return response()->json($data, 201);
    }



    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            $data = [
                'message' => 'get detail student',
                'data' => $student
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'data not found',
                'data' => $student
            ];
            return response()->json($data, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->update([
                'nama' => $request->nama ?? $student->nama,
                'nim' => $request->nim ?? $student->nim,
                'email' => $request->email ?? $student->email,
                'jurusan' => $request->jurusan ?? $student->jurusan
            ]);

            $data = [
                'message' => 'Student is updated',
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'data not found',
            ];
            return response()->json($data, 404);
        }
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();

            $data = [
                'message' => 'data is deleted'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'data not found'
            ];
            return response()->json($data, 404);
        }
    }
}
