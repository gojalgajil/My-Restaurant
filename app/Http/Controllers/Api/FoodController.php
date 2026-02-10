<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('available')) {
            $query->where('available', $request->boolean('available'));
        }

        $foods = $query->get();

        return response()->json([
            'success' => true,
            'data' => $foods
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $food = Food::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Food created successfully',
            'data' => $food
        ], 201);
    }

    public function show(string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $food
        ]);
    }

    public function update(Request $request, string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'category' => 'in:makanan,minuman',
            'price' => 'numeric|min:0',
            'image' => 'nullable|string',
            'available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $food->update($request->all());

        // Debug: Log the update
        Log::info('Food updated:', [
            'id' => $food->id,
            'request_data' => $request->all(),
            'updated_food' => $food->fresh()->toArray()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Food updated successfully',
            'data' => $food
        ]);
    }

    public function destroy(string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        $food->delete();

        return response()->json([
            'success' => true,
            'message' => 'Food deleted successfully'
        ]);
    }
}
