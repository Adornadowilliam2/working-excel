<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    // Store new visitor data
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "users" => "required|integer|min:1",   // Ensure users is an integer and greater than 0
            "visit_date" => "required|date", // Ensure visit_date is an integer and greater than 0
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        // Store validated data
        $visitor = Visitor::create($validator->validated());

        return response()->json([
            "ok" => true,
            "message" => "Created successfully",
            "data" => $visitor
        ], 201); 
    }

    // Get all visitors data
    public function index()
    {
        return response()->json([
            "ok" => true,
            "message" => "Data has been retrieved",
            "data" => Visitor::all()
        ], 200);
    }

    // Update a visitor entry
    public function update(Request $request)
    {
        $validator = validator($request->all(), [
            "id" => "required|exists:visitors,id",   // Ensure the visitor exists
            "users" => "required|integer|min:1",  // Validate users field
            "visit_date" => "required|date", // Validate visit_date field
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        $visitor = Visitor::findOrFail($validated["id"]);

        // Update visitor data
        $visitor->update([
            "users" => $validated["users"],
            "visit_date" => $validated["visit_date"],
        ]);

        return response()->json([
            "ok" => true,
            "message" => "Updated successfully",
            "data" => $visitor
        ], 200);
    }

    // Delete a visitor entry
    public function destroy(Request $request)
    {
        $validator = validator($request->all(), [
            "id" => "required|exists:visitors,id",  // Ensure the visitor exists
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        $visitor = Visitor::findOrFail($validated["id"]);

        // Delete the visitor entry
        $visitor->delete();
        
        return response()->json([
            "ok" => true,
            "message" => "Deleted successfully",
        ], 200);
    }
}
