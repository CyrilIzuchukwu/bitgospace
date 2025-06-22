<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalWalletAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Log;

class WithdrawalAddressController extends Controller
{
    //
    public function index()
    {
        $wallets = WithdrawalWalletAddress::latest()->paginate(10);
        return view('admin.withdrawal_wallet_address.index', compact('wallets'));
    }


    public function create()
    {
        return view('admin.withdrawal_wallet_address.create');
    }


    public function storeWallet(Request $request)
    {

        // dd('hi');
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:withdrawal_wallet_addresses,name',
                'address' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
            ], [
                'name.unique' => 'Currency name already exists',
                'symbol.required' => 'Symbol is required',
            ]);

            // dd($validator);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }


            WithdrawalWalletAddress::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'address' => $request->address,
                'symbol' => strtoupper($request->symbol),
            ]);

            return redirect()->route('withdrawals.wallet.index')->with('success', 'Wallet created successfully!');
        } catch (\Exception $e) {
            Log::error('Wallet creation error: ' . $e->getMessage());
            // dd('error', $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the wallet.' . $e->getMessage())->withInput();

            // dd('error', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $wallet = WithdrawalWalletAddress::findOrFail($id);
        return view('admin.withdrawal_wallet_address.edit', compact('wallet'));
    }




    public function update(Request $request, $id)
    {
        $wallet = WithdrawalWalletAddress::findOrFail($id);
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:wallet_addresses,name,' . $wallet->id,
                'address' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $wallet->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'address' => $request->address,
                'symbol' => strtoupper($request->symbol),
            ]);

            $wallet->save();

            return redirect()->route('withdrawals.wallet.index')->with('success', 'Wallet updated successfully!');
        } catch (\Exception $e) {
            Log::error('Wallet update error: ' . $e->getMessage());
            // return  back()->with('error', 'An error occurred while updating the wallet.');
            return redirect()->back()->with('error', 'An error occurred while updating the wallet.' . $e->getMessage())->withInput();
        }
    }



    public function destroy($id)
    {
        try {
            $wallet = WithdrawalWalletAddress::findOrFail($id);
            $wallet->delete();

            return redirect()->route('withdrawals.wallet.index')->with('success', 'Wallet deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting wallet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the wallet.');
        }
    }
}
