<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryUnit;

class BatteryUnitController extends Controller
{
    public function UnitList()
    {
        try {
            $units = BatteryUnit::all();
            return response()->json(['status' => 'success', 'units' => $units]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
