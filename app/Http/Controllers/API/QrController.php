<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Table;
use Illuminate\Support\Facades\Storage;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return response()->download(storage_path('/Qr/qrcode1.png'));
        $table = Table::find($id);

        $x = base64_encode(file_get_contents(storage_path('/Qr/'.$table->qr.'.png')));
        return response()->json(($x));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(300,1),
            new ImagickImageBackEnd()
        );
        $data = $request->only('id','place_id','number');
        $jsonified = json_encode($data);
        $table = Table::find($request->id);
        if($table)
        {
            Storage::disk("qr")->delete($table->qr.".png");
            $table->qr = "";
        }
        $name = md5($jsonified.microtime());
        $writer = new Writer($renderer);
        $writer->writeFile($jsonified, '../storage/Qr/'.$name.'.png');
        $table->qr = $name;
        $table->save();
        return response()->json("",201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
