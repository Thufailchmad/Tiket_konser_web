<?php

namespace App\Http\Controllers;

use App\Models\Booked_tickets;
use App\Models\Chart;
use App\Models\History;
use App\Models\History_Item;
use App\Models\Tickets;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = History::orderBy("created_at", "desc")->get();
        if (request()->header("user-agent") == "android") {
            return response()->json([
                'message' => 'data history',
                'data' => $history
            ], JsonResponse::HTTP_ACCEPTED);
        }
        return view("history", compact("history"));
    }

    public function adminIndex(Request $request)
    {
        $history = History::where("status", "!=", 0)->get();
        return view("admin.history.index", ["histories" => $history]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "ticket.*.qty" => ["required", "numeric", "max:100"],
            "ticket.*.ticketId" => ["required", "numeric"],
        ]);

        $sum = 0;
        foreach ($request->ticket as $key => $value) {
            $ticket = Tickets::where('id', '=', $value['ticketId'])->first();
            $sum += $value['qty'] * $ticket->price;
        }

        $history = History::create([
            'userId' => $request->user()->id,
            'total' => $sum,
        ]);
        $history->save();

        foreach ($request->ticket as $key => $value) {
            $ticket = Tickets::where('id', '=', $value['ticketId'])->first();
            $history_item = History_Item::create([
                'qty' => $value['qty'],
                'ticketId' => $value['ticketId'],
                'historyId' => $history->id
            ]);
            $history_item->save();

            $deleteChart = Chart::where('ticketId', '=', $value['ticketId'])
                ->where('userId', '=', $request->user()->id);
            $deleteChart->delete();
        }

        if ($request->header('user-agent') == 'android') {
            return response()->json([
                'message' => 'Transaksi berhasil',
                'historyId' => $history->id
            ], JsonResponse::HTTP_CREATED);
        }

        return redirect()->route('history.index')->with('success', 'Transaction created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $history = History::where('id', '=', $id)->first();

        if (request()->header('user-agent') == 'android') {
            return response()->json([
                'message' => 'Data History',
                'data' => $history
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return view('history.index', [
            'history' => $history
        ]);
    }

    public function uploadImage(Request $request, string $id)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
        ]);

        $ext = $request->file('file')->getClientOriginalExtension();
        $name = $id . "-" . now() . "." . $ext;
        $request->file('file')->storeAs(
            "payment-images",
            $name,
            ['disk' => 'public']
        );

        if ($request->header('user-agent') == 'android') {
            return response()->json([
                'message' => 'gambar berhasil diupload'
            ], JsonResponse::HTTP_ACCEPTED);
        }

        return redirect()->route('history.show', $id)->with('success', 'Image uploaded successfully!');
    }

    public function reqPayment(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'numeric', 'max:2'],
        ]);

        $history = History::where('id', '=', $id)->first();
        $history->status = $request->status;
        $history->save();

        if ($request->status == 1) {
            foreach ($history->historyItems as $item) {
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 12; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $booked_ticket = Booked_tickets::create([
                    'ticketId' => $item->ticketId,
                    'userId' => $request->user()->id,
                    'code' => $randomString
                ]);
                $booked_ticket->save();
            }
        }

        return redirect()->route('history.admin');
    }
}
