<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('table_id')) {
            $query->where('table_id', $request->table_id);
        }

        $orders = $query->with(['table', 'user', 'orderItems.food'])->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table_id' => 'required|exists:tables,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $table = Table::find($request->table_id);

        if (!$table->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Table is not available'
            ], 422);
        }

        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id' => $request->user()->id,
            'status' => 'open',
        ]);

        $table->markAsOccupied();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order->load(['table', 'user'])
        ], 201);
    }

    public function show(string $id)
    {
        $order = Order::with(['table', 'user', 'orderItems.food'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function addItem(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->isOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add items to closed order'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $food = \App\Models\Food::find($request->food_id);

        if (!$food->available) {
            return response()->json([
                'success' => false,
                'message' => 'Food is not available'
            ], 422);
        }

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'food_id' => $request->food_id,
            'quantity' => $request->quantity,
            'price' => $food->price,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item added to order successfully',
            'data' => $orderItem->load('food')
        ], 201);
    }

    public function closeOrder(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->isOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Order is already closed'
            ], 422);
        }

        $order->closeOrder();

        return response()->json([
            'success' => true,
            'message' => 'Order closed successfully',
            'data' => $order->load(['table', 'user', 'orderItems.food'])
        ]);
    }

    public function markAsPaid(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Order is already paid'
            ], 422);
        }

        $order->markAsPaid();

        return response()->json([
            'success' => true,
            'message' => 'Order marked as paid successfully',
            'data' => $order->load(['table', 'user', 'orderItems.food'])
        ]);
    }

    public function removeItem(Request $request, string $id, string $itemId)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->isOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot remove items from closed order'
            ], 422);
        }

        $orderItem = OrderItem::where('order_id', $order->id)->find($itemId);

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found'
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from order successfully'
        ]);
    }

    public function generateReceipt(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $receiptService = new ReceiptService();
        return $receiptService->generateReceipt($order);
    }

    public function getReceiptHTML(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $receiptService = new ReceiptService();
        $html = $receiptService->generateReceiptHTML($order);

        return response($html)->header('Content-Type', 'text/html');
    }
}
