<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ticket = Tickets::all()->where('expired', '>', now());
        if ($request->header('user-agent')=='android') {
            return response()->json([
                'message'=>'Data tiket',
                'data'=>$ticket
                ], JsonResponse::HTTP_OK);
        }
        return view('home', ['tickets_list'=>$ticket]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required', 'string', 'max:50'],
            'expired'=>['required', 'date'],
            'description'=>['string'],
            'price'=>['required', 'numeric'],
            'images'=>['required', 'file', 'max:512', 'mimes:jpg,jpeg,png']
        ]);

        $ext = $request->file('images')->getClientOriginalExtension();
        $name = $request->name . "-" . $request->expired . "." . $ext;
        $request->file('images')->storeAs(
            "ticket-images",
            $name, 
            ['disk'=>'public']
        );

        $ticket = Tickets::create([
            'name'=>$request->name,
            'expired'=>$request->expired,
            'description'=>$request->description,
            'price'=>$request->price,
            'images'=>"storage/ticket-images/".$name
        ]);

        if($request->header("user-agent") == "android"){
            return response()->json(['message'=>'Tiket sukses dibuat'], JsonResponse::HTTP_CREATED);
        }

        return view('', ['message'=>'Tiket sukses disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $ticket = Tickets::where('id', (int) $id)->first();
        if($request->header('user-agent') == 'android'){
            return response()->json([
                'message'=> 'Data tiket',
                'data'=>$ticket
            ], JsonResponse::HTTP_ACCEPTED);
        }
        return view('', ['ticket'=>$ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Tickets::where('id', (int) $id)->first();
        return view('', ['ticket'=>$ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>['string', 'max:50'],
            'description'=>['string'],
            'price'=>['numeric']
        ]);

        $ticket = Tickets::where('id', '=', (int) $id)->first();
        $ticket->name=$request->name;
        $ticket->description=$request->description;
        $ticket->price=$request->price;
        $ticket->save();

        if($request->header('user-agent') == 'android'){
            return response()->json(['message'=>'Update berhasil'], JsonResponse::HTTP_ACCEPTED);
        }
        return view('', ['message'=>'Update berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $ticket = Tickets::destroy((int) $id);
        if($request->header('user-agent') == 'android'){
            return response()->json(['message'=> 'tiket berhasil dihapus'], JsonResponse::HTTP_ACCEPTED);
        }
        return view('', ['message'=>'Tiket berhasil di hapus']);
    }
}
