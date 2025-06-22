<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletAddress;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WalletAddressController extends Controller
{
    //

    public function index()
    {
        $wallets = WalletAddress::latest()->paginate(10);
        return view('admin.wallet_address.index', compact('wallets'));
    }


    public function create()
    {
        return view('admin.wallet_address.create');
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:wallet_addresses,name',
                'address' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'qr_code' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // max 2MB
            ], [
                'name.unique' => 'Currency name already exists',
                'address.unique' => 'Wallet address already exists',
                'symbol.required' => 'Symbol is required',
                'qr_code.image' => 'QR Code must be an image',
                'qr_code.mimes' => 'Allowed formats: jpg, jpeg, png, gif',
            ]);

            // dd($validator);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Handle QR Code upload if provided
            $qrPath = null;
            if ($request->hasFile('qr_code')) {
                $qrPath = $request->file('qr_code')->store('wallet_qr_codes', 'public');
            }

            WalletAddress::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'address' => $request->address,
                'symbol' => strtoupper($request->symbol),
                'qr_code' => $qrPath,
            ]);

            return redirect()->route('wallets.index')->with('success', 'Wallet created successfully!');
        } catch (\Exception $e) {
            Log::error('Wallet creation error: ' . $e->getMessage());
            // dd('error', $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the wallet.' . $e->getMessage())->withInput();

            // dd('error', $e->getMessage());
        }
    }


    public function edit(WalletAddress $wallet)
    {
        return view('admin.wallet_address.edit', compact('wallet'));
    }


    public function update(Request $request, WalletAddress $wallet)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:wallet_addresses,name,' . $wallet->id,
                'address' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'qr_code' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Handle QR Code upload
            if ($request->hasFile('qr_code')) {
                // Delete old QR code if exists
                if ($wallet->qr_code && Storage::disk('public')->exists($wallet->qr_code)) {
                    Storage::disk('public')->delete($wallet->qr_code);
                }
                $qrPath = $request->file('qr_code')->store('wallet_qr_codes', 'public');
                $wallet->qr_code = $qrPath;
            }

            $wallet->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'address' => $request->address,
                'symbol' => strtoupper($request->symbol),
            ]);

            $wallet->save();

            return redirect()->route('wallets.index')->with('success', 'Wallet updated successfully!');
        } catch (\Exception $e) {
            Log::error('Wallet update error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the wallet.');
        }
    }



    public function destroy(WalletAddress $wallet)
    {
        try {
            // Delete QR code file if it exists
            if ($wallet->qr_code && Storage::disk('public')->exists($wallet->qr_code)) {
                Storage::disk('public')->delete($wallet->qr_code);
            }

            // Delete wallet
            $wallet->delete();

            return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting wallet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the wallet.');
        }
    }
}
