<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;
use Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient = Patient::all();
        $data = $patient->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Patients retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'surname' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $patient = Patient::create($input);
        $data = $patient->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Patient stored successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        $data = $patient->toArray();

        if (is_null($patient)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Patient not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Patient retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'surname' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $patient->name = $input['name'];
        $patient->surname = $input['surname'];
        $patient->birth = $input['birth'];
        $patient->save();

        $data = $patient->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Patient updated successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        $data = $patient->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Patient deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
