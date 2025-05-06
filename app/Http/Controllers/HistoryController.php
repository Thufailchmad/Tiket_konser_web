<?php

namespace App\Http\Controllers;

use App\Models\Booked_tickets;
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
        $history = History::orderBy("created_at","desc");
        if (request()->header("user-agent")=="android") {
            return response()->json([
                'message'=>'data history',
                'data'=> $history
            ], JsonResponse::HTTP_ACCEPTED);
        }   
        return view("", compact(""));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "ticket.*.qty"=> ["required", "numeric","max:100"],
            "ticket.*.ticketId"=> ["required", "numeric"],
        ]);

        $sum = 0;
        foreach ($request->ticket as $key => $value) {
            $ticket = Tickets::where('id', '=', $value->ticketId)->first();
            $sum += $value->qty * $ticket->price;
        }

        $history = History::create([
            'userId'=> $request->user()->id,
            'total'=>$sum,
        ]);
        $history->save();

        foreach ($request->ticket as $key => $value) {
            $ticket = Tickets::where('id', '=', $value->ticketId)->first();
            $history_item = History_Item::create([
                'qty'=>$value->qty,
                'ticketId'=>$value->ticketId,
                'historyId'=>$history->id
            ]);
            $history_item->save();
        }

        if($request->header('user-agent') == 'android') {
            return response()->json([
                'message'=>'Transaksi berhasil'
            ],JsonResponse::HTTP_CREATED);
        }

        return view('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $history = History::where('id','=', $id)->first();

        if(request()->header('user-agent') == 'android') {
            return response()->json([
                'message'=>'Data History',
                'data'=> $history
            ],JsonResponse::HTTP_ACCEPTED);
        }

        return view('', [
            'history' => $history
        ]);
    }

    public function uploadImage(Request $request, string $id)
    {
        $request->validate([
            'file'=>['required', 'file', 'max:512', 'mimes:jpg,jpeg,png'],
        ]);
        
        $ext = $request->file('file')->getClientOriginalExtension();
        $name = $id. "-". now() . "." . $ext;
        $request->file('file')->storeAs(
            "payment-images",
            $name, 
            ['disk'=>'public']
        );

        return response()->json([
            'message'=>'gambar berhasil diupload'
        ],JsonResponse::HTTP_ACCEPTED);
    }

    public function reqPayment(Request $request, string $id)
    {
        $request->validate([
            'status'=>['required', 'numeric', 'max:2'],
        ]);

        $history = History::where('id','=', $id)->first();
        $history->status = $request->status;
        $history->save();

        if($request->status == 1) {
            foreach($history->historyItems() as $item) {
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 12; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
    
                $booked_ticket = Booked_tickets::create([
                    'ticketId'=>$item->ticketId,
                    'userId'=>$request->user()->id,
                    'code'=>$randomString
                ]);
            }
        }

        return view('');
    }
}
