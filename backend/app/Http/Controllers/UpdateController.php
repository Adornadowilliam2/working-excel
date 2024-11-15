<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    // Create a new Update record
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = validator($request->all(), [
            "visitors" => "required|string|max:255",  // Name or ID of the visitor
            "time" => "required|string", // Validate that the time is a valid datetime format
            "date" => "required|string", // Ensure time is in correct format
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors(),
            ], 400);
        }

        // Create the Update record
        $update = Update::create($validator->validated());

        return response()->json([
            "ok" => true,
            "message" => "Created successfully",
            "data" => $update,
        ], 201);
    }

    // Retrieve all Update records
    public function index()
    {
        return response()->json([
            "ok" => true,
            "message" => "Data has been retrieved",
            "data" => Update::all(),
        ], 200);
    }

    // Update an existing Update record
    public function update(Request $request)
    {
        // Validate the incoming request
        $validator = validator($request->all(), [
            "id" => "required|exists:updates,id",  // Ensure the record exists
            "visitors" => "required|string|max:255",      // Name or ID of the visitor
            "time" => "required|string", // Ensure time is in correct format
            "date" => "required|string", // Ensure time is in correct format
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors(),
            ], 400);
        }

        $validated = $validator->validated();

        // Find the record to update
        $update = Update::findOrFail($validated['id']);

        // Update the record
        $update->update([
            "visitors" => $validated['visitors'],
            "time" => $validated['time'],
            "date" => $validated['date'],
        ]);

        return response()->json([
            "ok" => true,
            "message" => "Updated successfully",
            "data" => $update,
        ], 200);
    }

    // Delete an Update record
    public function destroy(Request $request)
    {
        // Validate the incoming request
        $validator = validator($request->all(), [
            "id" => "required|exists:updates,id",  // Ensure the record exists
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors(),
            ], 400);
        }

        $validated = $validator->validated();

        // Find the record and delete it
        $update = Update::findOrFail($validated['id']);
        $update->delete();

        return response()->json([
            "ok" => true,
            "message" => "Deleted successfully",
        ], 200);
    }
}
