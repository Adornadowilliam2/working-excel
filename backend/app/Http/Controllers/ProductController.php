<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{

    public function store(Request $request){
        $validator = validator($request->all(), [
            "link" => "required|string",
            "content" => "required|string",
            "remarks" => "required|string",
            "views" => "required|integer", 
            "comment" => "required|string",
            "like" => "required|integer", 
            "link_clicked" => "required|integer",  
            "share" => "required|integer", 
            "save" => "required|integer", 
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }


        
        $product = Product::create($validator->validated());

        return response()->json([
            "ok" => true,
            "message" => "Created successfully",
            "data" => $product
        ], 201); 
    }

    
     public function index(){
        return response()->json([
            "ok"=> true, 
            "message" => "Data has been retrieve",
            "data" => Product::all()
        ], 200);
     }


     public function update(Request $request){
        $validator = validator($request->all(), [
            "id" => "required|exists:products,id",  
            "link" => "required", 
            "content" => "required", 
            "remarks" => "required", 
            "views" => "required|integer", 
            "comment" => "required", 
            "like" => "required|integer", 
            "link_clicked" => "required|integer",  
            "share" => "required|integer", 
            "save" => "required|integer" 
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        
        $validated = $validator->validated();
        
        
        $product = Product::findOrFail($validated["id"]);

        
        $product->update([
            "link" => $validated["link"],
            "content" => $validated["content"],
            "remarks" => $validated["remarks"],
            "views" => $validated["views"],
            "comment" => $validated["comment"],
            "like" => $validated["like"],
            "link_clicked" => $validated["link_clicked"], 
            "share" => $validated["share"],
            "save" => $validated["save"]
        ]);

        
        return response()->json([
            "ok" => true,
            "message" => "Updated successfully",
            "data" => $product
        ], 200);
    }


    public function destroy(Request $request){
        $validator =  validator($request->all(), [
            "id" => "required|exists:products,id",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "message" => "Request didn't pass validation",
                "data" => $validator->errors()
            ], 400);
        }

        
        $validated = $validator->validated();
        
        
        $product = Product::findOrFail($validated["id"]);

        $product->delete();
        return response()->json([
            "ok" => true,
            "message" => "Deleted successfully",
        ], 200);
    }
}
