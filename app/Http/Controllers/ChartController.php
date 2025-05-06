<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $chart = Chart::where("userId", $user->id)->get();
        if($request->header("user-agent")=="android") {
            return response()->json([
                'message'=>'data chart',
                'data'=> $chart
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return view('', ['charts'=> $chart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticketId'=> ['required', 'numeric',],
            'qty'=> ['required', 'numeric', 'max:100' ],
        ]);
        $chart = Chart::create([
            'qty'=> $request->qty,
            'userId'=> $request->user()->id,
            'ticketId'=>$request->ticketId
        ]);

        if($request->header('user-agent')== 'android') {
            return response()->json([
                'message'=>'Tiket berhasil ditambahkan ke keranjang'
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return view('');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ticketId'=> ['numeric',],
            'qty'=> ['numeric', 'max:100' ],
        ]);
        $chart = Chart::where($id);
        $chart->update([
            'qty'=> $request->qty,
            'ticketId'=>$request->ticketId
        ]);
        if($request->header('user-agent')== 'android') {
            return response()->json([
                'message'=> 'Keranjang berhasil diperbarui'
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return view('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $chart = Chart::findOrFail((int) $id);
        $chart->delete();
        if($request->header('user-agent')== 'android') {
            return response()->json([
                'message'=> 'Keranjang berhasil dihapus'
            ], JsonResponse::HTTP_ACCEPTED);
        }
        return view('');
    }
}
