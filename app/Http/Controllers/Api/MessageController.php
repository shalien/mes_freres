<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        DB::beginTransaction();

        $from = Crypt::encryptString($request->all()['from']);
        $to = Crypt::encryptString($request->all()['to']);
        $content = Crypt::encryptString($request->all()['content']);

        try {
            $message = Message::create([
                'from' => $from,
                'to' => $to,
                'content' => $content,
            ]);
            DB::commit();
            return response()->json($message, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Store failed!'], 409);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //

        $message->from = Crypt::decryptString($message->from);
        $message->to = Crypt::decryptString($message->to);
        $message->content = Crypt::decryptString($message->content);

        return response()->json($message, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
        return response()->json($message->delete(), 204);
    }
}
