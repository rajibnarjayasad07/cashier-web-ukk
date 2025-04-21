<?php

namespace App\Http\Controllers;

use App\Models\id;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['customer', 'user'])->get();
        return view('sharingpage.transaction', compact('transactions'));
    }

    /**
     * Show the form for ideating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('cashier.transaction.choose-product', compact('products'));
    }

    /**
     * Store a newly ideated resource in storage.
     */
    public function store(Request $request)
    {
        $products = Session::get('products');
        $totalPrice = (int) str_replace(['Rp.', ',', '.'], '', $request->total_price);
        $totalPayment = (int) str_replace(['Rp.', ',', '.'], '', $request->total_payment);

        $transaction = Transaction::create([
            'transaction_date' => now(),
            'total_price' => $totalPrice,
            'total_payment' => $totalPayment,
            'total_return' => $totalPayment - $totalPrice,
            'customers_id' => $request->member_status === 'member' ? 0 : 0,
            'users_id' => auth()->id(),
            'loyalty_points' => 0,
            'total_point' => 0,
        ]);

        foreach ($products as $product) {
            // Create detail transaction
            DetailTransaction::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product['id'],
                'amount' => $product['quantity'],
                'sub_total' => $product['subtotal'],
            ]);

            // Update product stock
            $productModel = Product::findOrFail($product['id']);
            $productModel->update([
                'stock' => $productModel->stock - $product['quantity'],
            ]);
        }

        if ($request->member_status === 'member') {
            return redirect()->route('transaction.member-identity', ['transaction_id' => $transaction->id, 'phone' => $request->member_phone]);
        }

        return redirect()->route('transaction.invoice', ['id' => $transaction->id])->with('success', 'Transaction successfully.');
    }

    public function memberIdentity($transaction_id, $phone)
    {
        if (!$transaction_id || !$phone) {
            return redirect()->route('transaction.create')->with('error', 'Transaction ID or phone is missing.');
        }

        $customer = Customer::where('phone', $phone)->first();
        $transaction = Transaction::with('detailTransaction.product')->findOrFail($transaction_id);

        return view('cashier.transaction.member-identity', compact('customer', 'transaction', 'phone'));
    }

    public function updateMember(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        $customer = Customer::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => $request->member_name, 'loyalty_points' => 0]
        );

        $pointsEarned = (int)floor($transaction->total_price * 0.01);
        $pointsUsed = (int) $request->use_points ?? 0;
        $customerLoyaltyPoints = $customer->loyalty_points != null ? (int) $customer->loyalty_points : 0;

        $transaction->update([
            'customers_id' => $customer->id,
            'loyalty_points' => $pointsEarned,
            'total_payment' => $transaction->total_payment - $pointsUsed,
            'total_return' => $transaction->total_return + $pointsUsed,
            'total_point' => $pointsUsed,
        ]);


        $customer->update([
            'loyalty_points' => ($customerLoyaltyPoints - $pointsUsed) + $pointsEarned,
        ]);

        return redirect()->route('transaction.invoice', ['id' => $transaction->id])
            ->with('success', 'Transaction successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(id $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(id $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, id $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(id $id)
    {
        //
    }

    public function detail(Request $request)
    {
        $productIds = array_keys(json_decode($request->products, true));
        $products = Product::whereIn('id', $productIds)->get()->map(function ($product) use ($request) {
            $quantity = json_decode($request->products, true)[$product->id];
            return [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ];
        });

        if ($products->isEmpty()) {
            return redirect()->route('transaction.create')->with('error', 'No products found.');
        }

        Session::put('products', $products);
        return view('cashier.transaction.detail-transaction', compact('products'));
    }

    public function invoice($id)
    {
        $transaction = Transaction::with(['customer', 'detailTransaction.product'])->findOrFail($id);
        return view('cashier.transaction.invoice-transaction', compact('transaction'));
    }

    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Delete related detail transactions
        $transaction->detailTransaction()->delete();

        // Delete the transaction
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction canceled successfully.');
    }
}
