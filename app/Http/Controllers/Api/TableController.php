<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $query = Table::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tables = $query->with(['orders' => function($query) {
            $query->where('status', 'open');
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $tables
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|unique:tables,number',
            'capacity' => 'integer|min:1|max:20',
            'status' => 'in:available,occupied',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $table = Table::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Table created successfully',
            'data' => $table
        ], 201);
    }

    public function show(string $id)
    {
        $table = Table::with(['orders' => function($query) {
            $query->where('status', 'open')->with('orderItems.food');
        }])->find($id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $table
        ]);
    }

    public function update(Request $request, string $id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'number' => 'string|unique:tables,number,' . $id,
            'capacity' => 'integer|min:1|max:20',
            'status' => 'in:available,occupied',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $table->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Table updated successfully',
            'data' => $table
        ]);
    }

    public function destroy(string $id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found'
            ], 404);
        }

        if ($table->orders()->where('status', 'open')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete table with active orders'
            ], 422);
        }

        $table->delete();

        return response()->json([
            'success' => true,
            'message' => 'Table deleted successfully'
        ]);
    }

    public function getAvailableTables()
    {
        $tables = Table::where('status', 'available')->get();

        return response()->json([
            'success' => true,
            'data' => $tables
        ]);
    }
}
