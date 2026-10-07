<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatteryOpeningBalanceController extends Controller
{
    public function OpeningBalanceList()
    {
        try {
            $data = BatteryOpeningBalance::where('user_id', Auth::id())
                ->latest()
                ->get();

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

    public function OpeningBalanceCreate(Request $request)
    {
        try {
            $request->validate([
                'date'   => 'required|date',
                'amount' => 'required|numeric|min:0',
                'note'   => 'nullable|string|max:500'
            ]);

            $balance = BatteryOpeningBalance::updateOrCreate(
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

    public function OpeningBalanceById(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);

            $data = BatteryOpeningBalance::where('id', $request->id)
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

    public function OpeningBalanceUpdate(Request $request)
    {
        try {
            $request->validate([
                'id'     => 'required',
                'date'   => 'required|date',
                'amount' => 'required|numeric|min:0',
                'note'   => 'nullable|string|max:500'
            ]);

            $balance = BatteryOpeningBalance::where('id', $request->id)
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

    public function OpeningBalanceDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);

            $balance = BatteryOpeningBalance::where('id', $request->id)
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
