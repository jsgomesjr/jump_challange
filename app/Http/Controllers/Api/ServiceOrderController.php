<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{

    public function index(Request $request)
    {
        $paginator = 5;
        $query = ServiceOrder::query()->with('users');

        if ($request->has('vehiclePlate')) {
            $query->where('vehiclePlate', $request->input('vehiclePlate'));
        }

        $serviceOrders = $query->paginate($paginator);

        return response()->json($serviceOrders);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vehiclePlate' => 'required|string|size:7',
            'entryDateTime' => 'required|date',
            'exitDateTime' => 'nullable|date',
            'priceType' => 'nullable|string|max:55',
            'price' => 'nullable|numeric',
            'userId' => 'required|exists:users,id'
        ]);

        $serviceOrder = ServiceOrder::create($validatedData);

        return response()->json($serviceOrder, 201);
    }
}
