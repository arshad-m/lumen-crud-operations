<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //constructor code
    }

    /**
     * Function to fetch student details
     * @param string: Student id
     * @return Json payload containing student details
     */
    public function read($student_id){
        $student_record = Student::with('student_document')->find($student_id);

        if($student_record){

            // encode the student doc if any
            if(!empty($student_record->student_document)){
                foreach($student_record->student_document as $key=>$doc){
                    $doc->file = base64_encode($doc->file);
                    $student_record->student_document[$key] = $doc;
                }
            }

            return response()->json($student_record->student_document, 200);
        }else{
            return response([], 204);
        }
    }

    /**
     * Function to fetch all student details
     * @return Json payload containing student details
     */
    public function readAll(){
        $student_record = Student::all();
        if($student_record->count() > 0){
            return response()->json($student_record, 200);
        }else{
            return response([], 204);
        }
    }


    /**
     * Function to create student
     * @param array : $http_request array
     * @return Json payload of inserted student details
     */
    public function create(Request $request){
        $this->validate($request, [
            'first_name' => 'required', 
            'last_name' => 'required', 
            'parent_name' => 'required', 
            'standard' => 'required|numeric', 
            'course' => 'required', 
            'email' => 'email'
        ]);

        $student = Student::create($request->all());

        return response()->json($student, 201);
    }

    /**
     * Function to Update student details
     * @param string : student_id
     * @param array : $http_request array
     * @return Json payload of updated student details
     */
    public function update($id, Request $request){
        $students = Student::find($id);
        if($students){
            // if found return the the updated record values 
            $students->update($request->all());
            return response()->json($students, 200);
        }else {
            // if record not found return response with 204 content not available
            // OR we can return empty records with 200 status
            return response('Records not found', 204);
        }

    }

    /**
     * Function to Delete student
     * @param string : student_id
     * @return Json payload with success message
     */
    public function delete($id){
        // $result = Student::findOrFail($id)->delete();

        $Student = Student::where('id', $id);
        if($result){
            $Student->delete();
            return response('Deleted Successfully', 200);
        }else{
            return response('', 204);
        }

    }
}
