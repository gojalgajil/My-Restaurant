<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\View;

class ReceiptService
{
    public function generateReceipt(Order $order)
    {
        $order->load(['table', 'user', 'orderItems.food']);
        
        $data = [
            'order' => $order,
            'restaurant' => [
                'name' => 'Restaurant API',
                'address' => 'Jl. Contoh No. 123, Jakarta',
                'phone' => '+62 21 1234 5678',
                'email' => 'info@restaurant.com',
            ],
            'date' => now()->format('d F Y H:i'),
        ];

        $html = View::make('receipts.order', $data)->render();

        return $this->generatePDF($html, 'receipt-' . $order->id . '.pdf');
    }

    private function generatePDF($html, $filename)
    {
        // Simple HTML to PDF conversion using basic approach
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        echo $html;
        exit;
    }

    public function generateReceiptHTML(Order $order)
    {
        $order->load(['table', 'user', 'orderItems.food']);
        
        $data = [
            'order' => $order,
            'restaurant' => [
                'name' => 'Restaurant API',
                'address' => 'Jl. Contoh No. 123, Jakarta',
                'phone' => '+62 21 1234 5678',
                'email' => 'info@restaurant.com',
            ],
            'date' => now()->format('d F Y H:i'),
        ];

        return View::make('receipts.order', $data)->render();
    }
}
