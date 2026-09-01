<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpeningBalanceController extends Controller
{
   // OpeningBalanceController.php
public function OpeningBalanceList()
{
    try {
        $data = OpeningBalance::where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $data  // এটাই রাখো, LocationData না!
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status'  => 'fail',
            'message' => $e->getMessage()
        ]);
    }
}

    // ২. ক্রিয়েট করবে
    public function OpeningBalanceCreate(Request $request)
    {
        try {
            $request->validate([
                'date'   => 'required|date',
                'amount' => 'required|numeric|min:0',
                'note'   => 'nullable|string|max:500'
            ]);

            $balance = OpeningBalance::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'date'    => $request->date
                ],
                [
                    'amount' => $request->amount,
                    'note'   => $request->note
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Opening Balance saved successfully!',
                'data'    => $balance
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    // ৩. আইডি দিয়ে ডাটা আনবে (এডিটের জন্য)
    public function OpeningBalanceById(Request $request)
    {
        try {
            $request->validate(['id' => 'required|string']);

            $data = OpeningBalance::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$data) {
                return response()->json(['status' => 'fail', 'message' => 'Not found']);
            }

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    // ৪. আপডেট করবে
    public function OpeningBalanceUpdate(Request $request)
    {
        try {
            $request->validate([
                'id'     => 'required|string',
                'date'   => 'required|date',
                'amount' => 'required|numeric|min:0',
                'note'   => 'nullable|string|max:500'
            ]);

            $balance = OpeningBalance::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$balance) {
                return response()->json(['status' => 'fail', 'message' => 'Not found']);
            }

            $balance->date   = $request->date;
            $balance->amount = $request->amount;
            $balance->note   = $request->note;
            $balance->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Opening Balance updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    // ৫. ডিলিট করবে
    public function OpeningBalanceDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required|string']);

            $balance = OpeningBalance::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$balance) {
                return response()->json(['status' => 'fail', 'message' => 'Not found']);
            }

            $balance->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Opening Balance deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }
}