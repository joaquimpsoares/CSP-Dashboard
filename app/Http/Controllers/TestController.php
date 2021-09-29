<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Mailer::withCustomSmtpCredentials("smtp.loquesea.com", 2525, 'tls', 'usuario', 'contraseña', function(){
            Mail::send(); // Este email se enviará con las credenciales custom
        });

        Mail::send(); // Este se enviará con las credenciales por defecto porque está fuera de la función anónima
    }
}
