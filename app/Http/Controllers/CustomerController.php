<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    // PROVIDER: Daftar semua user
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'success' => true,
            'service' => 'UserService',
            'data' => $customers
        ]);
    }

    // PROVIDER: Detail 1 user berdasarkan ID
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'service' => 'UserService',
            'data' => $customer
        ]);
    }

    // PROVIDER: Tambah user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'service' => 'UserService',
            'data' => $customer
        ], 201);
    }

    // CONSUMER: Ambil histori pesanan dari OrderService
    public function getOrders($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        // HTTP request ke OrderService (consumer role)
        $orderServiceUrl = env('ORDER_SERVICE_URL', 'http://localhost:8003');

        try {
            $response = Http::timeout(5)->get("{$orderServiceUrl}/api/orders/user/{$id}");

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch orders from OrderService',
                    'customer' => $customer
                ], 502);
            }

            return response()->json([
                'success' => true,
                'service' => 'UserService (consuming OrderService)',
                'customer' => $customer,
                'orders' => $response->json('data', [])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'OrderService tidak dapat dijangkau: ' . $e->getMessage(),
                'customer' => $customer,
                'orders' => []
            ], 503);
        }
    }
}