<?php

namespace App\Http\Controllers;
use App\Models\Query;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function store(Request $request){
        $validator = validator($request->all(), [
            "top_search_queries" => "required|string",   
            "clicks" => "required|integer",               
            "impressions" => "required|integer",   
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        
        $query = Query::create($validator->validated());

        return response()->json([
            "ok" => true,
            "message" => "Created successfully",
            "data" => $query
        ], 201); 
    }

    public function index(){
        return response()->json([
            "ok"=> true, 
            "message" => "Data has been retrieved",
            "data" => Query::all()
        ], 200);
    }

    public function update(Request $request){
        $validator = validator($request->all(), [
            "id" => "required|exists:queries,id",   
            "top_search_queries" => "required|string",   
            "clicks" => "required|integer",               
            "impressions" => "required|integer",           
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();
        
        
        $query = Query::findOrFail($validated["id"]);

        $query->update([
            "top_search_queries" => $validated["top_search_queries"],
            "clicks" => $validated["clicks"],
            "impressions" => $validated["impressions"],
        ]);

        return response()->json([
            "ok" => true,
            "message" => "Updated successfully",
            "data" => $query
        ], 200);
    }

    public function destroy(Request $request){
        $validator =  validator($request->all(), [
            "id" => "required|exists:queries,id",  
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();
        
        
        $query = Query::findOrFail($validated["id"]);

        $query->delete();
        return response()->json([
            "ok" => true,
            "message" => "Deleted successfully",
        ], 200);
    }
}
