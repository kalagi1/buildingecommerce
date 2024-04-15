<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller {
    public function store( Request $request ) {
        $formData = $request->except( '_token' );

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

        // Store ID'yi ekle
    $formData['store_id'] = $request->input('store_id');

    // Veritabanına kaydet
    Form::create($formData);

    // Başarılı bir şekilde kaydedildiğine dair mesaj gönder
    return redirect()->back()->with('success', 'Takas Başvurunuz Başarıyla Gönderildi!' );
    }

}
