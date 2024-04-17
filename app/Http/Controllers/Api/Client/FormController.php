<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store( Request $request ) {
        $formData = $request->all();

        if ( $request->hasFile( 'tapu_belgesi' ) ) {
            $tapuFile = $request->file( 'tapu_belgesi' );
            $tapuFileName =  'tapu_belgesi_' . time() . '.' . $tapuFile->getClientOriginalName();
            $tapuPath = $tapuFile->storeAs( 'tapuFiles', $tapuFileName, 'public' );
            $formData[ 'tapu_belgesi' ] = $tapuPath;
        }

        if ( $request->hasFile( 'ruhsat_belgesi' ) ) {
            $ruhsatFile = $request->file( 'ruhsat_belgesi' );
            $ruhsatFileName = 'ruhsat_belgesi_' . time() . '.' . $ruhsatFile->getClientOriginalExtension();
            $ruhsatFile->storeAs( 'ruhsatFiles', $ruhsatFileName, 'public' );
            $formData[ 'ruhsat_belgesi' ] = $ruhsatFileName;
        }

        $formData['store_id'] = $request->input('store_id');

        Form::create($formData);

        return json_encode([
            "status" => true,
            "message" => 'Takas Başvurunuz Başarıyla Gönderildi!'
        ]);
    }
}
