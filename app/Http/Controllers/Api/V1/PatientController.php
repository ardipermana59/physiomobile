<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\PatientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Patient::with('user')->get();

        return ApiResponse::success(message: 'Data retrieved successfully.', data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        try {
            $user = User::create(array_merge(
                $request->only([
                    'name',
                    'id_type',
                    'id_no',
                    'gender',
                    'dob',
                    'address'
                ]),
                ['email' => Str::random(10) . '@gmail.com'],
                ['password' => Hash::make('password')],
            ));

            $patient = Patient::create([
                'user_id' => $user->id,
                'medium_acquisition' => $request->medium_acquisition,
            ]);

            return ApiResponse::success($patient->load('user'), 'Patient created successfully', 201);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to create patient', 500, $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return ApiResponse::error('Patient not found', 404);
        }

        return ApiResponse::success($patient, 'Patient details');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
        $patient = Patient::with('user')->find($id);
        if (!$patient) {
            return ApiResponse::error('Patient not found', 404);
        }

        $patient->user->update($request->only(['name', 'id_type', 'id_no', 'gender', 'dob', 'address']));
        $patient->update(['medium_acquisition' => $request->medium_acquisition]);

        return ApiResponse::success($patient->load('user'), 'Patient updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return ApiResponse::error('Patient not found', 404);
        }

        $patient->user->delete();

        return ApiResponse::success(null, 'Patient deleted');
    }
}
