<?php

if (!function_exists('riderChart')) {
    function riderChart($id)
    {
        $orders = [];
        
        $dynamicChartData = [];
        
         if (Auth::check()) {
             $orders = Order::where('rider_id', $id)
            ->select('created_at', 'total_amount')
            ->orderBy('created_at')
            ->get();

            foreach ($sales as $sale) {
                // Format the timestamp and revenue values as needed
                $timestamp = strtotime($sale->created_at) * 1000; // Convert to milliseconds
                $revenue = $sale->total_amount;
                
                $dynamicChartData[] = [$timestamp, $revenue];
            }
         }
        
        return $dynamicChartData;
    }
}