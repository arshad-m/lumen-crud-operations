<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StudentDocument;
use App\Student;

class StudentDocumentController extends Controller
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
     * Function to fetch student_documents details
     * @param string: document id
     * @param string: Student id
     * @return Json payload containing student_documents details
     */
    public function read($document_id, $student_id){
        $document_record = StudentDocument::find(['studendt_id'=>$student_id, 'id'=>$document_id])->first();
        if($document_record){
            // convert binary data to base64_encode
            $document_record->file = base64_encode($document_record->file);
            return response()->json($document_record, 200);
        }else{
            return response([], 204);
        }
    }

    /**
     * Function to create student
     * @param array : $http_request array with doc_type array & file array
     * @return Json payload of inserted student_documents details
     */
    public function create(Request $request, $student_id){
        $this->validate($request, [
                'file' => 'required',
                // 'file.*' => 'mimes:doc,pdf,docx,zip'
        ]);


        $doc_type = $request->input('doc_type');
        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $key => $file)
            {
                $data = array(
                    'student_id' => $student_id,
                    'doc_type' => isset($doc_type[$key]) ? $doc_type[$key] : 'other',
                    'file_name' => $file->getClientOriginalName(),
                    'file_extension' => explode('.',$file->getClientOriginalName())[1],
                    'mime_type' => $file->getClientMimeType(),
                    'file' => file_get_contents($file->getPathname()),
                );
                $inserted_record = StudentDocument::create($data);

                // convert binary data back to base64_encode
                $inserted_record->file = base64_encode($inserted_record->file);
                $document[] = $inserted_record;
            }

        }

        return response()->json($document, 201);
    }

    /**
     * Function to Update student_documents details
     * @param array : $http_request array
     * @param string : document id
     * @param string : student id
     * @return Json payload of updated student_documents details
     */
    public function update(Request $request, $document_id, $student_id){
        $document = StudentDocument::find($document_id);

        if($document && $request->hasfile('file')){

            // if found and has file then return the updated record values 
            $file = $request->file('file');

            $document->doc_type = $request->has('doc_type') ? $request->input('doc_type') : 'other';
            $document->file_name = $file->getClientOriginalName();
            $document->file_extension = explode('.',$file->getClientOriginalName())[1];
            $document->mime_type = $file->getClientMimeType();
            $document->file = file_get_contents($file->getPathname());

            $document->save();

            // convert binary data back to base64_encode
            $document->file = base64_encode($document->file);
            return response()->json($document, 200);
        }else {
            // if record not found return response with 204 content not available
            // OR we can return empty records with 200 status
            return response('Records not found', 204);
        }

    }

    /**
     * Function to Delete student document
     * @param string : student id
     * @param string : document id
     * @return Json payload with success message
     */
    public function delete($student_id, $id){

        $document = StudentDocument::where(['student_id'=>$student_id, 'id'=>$id]);
        if($document){
            $document->delete();
            return response('Deleted Successfully', 200);
        }else{
            return response('', 204);
        }

    }
}
