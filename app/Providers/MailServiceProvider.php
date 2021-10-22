<?php

namespace App\Providers;

use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Swift_SmtpTransport;
use Swift_Mailer;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Mailer::macro('withCustomSmtpCredentials', function($hostname, $port, $encription, $username, $password, $callback){
            $backup = Mail::getSwiftMailer();

            $transport = new Swift_SmtpTransport($hostname, $port, $encription);
            $transport->setUsername($username);
            $transport->setPassword($password);

            $custom = new Swift_Mailer($transport);

            Mail::setSwiftMailer($custom);

            $callback();

            Mail::setSwiftMailer($backup);
        });
    }
}
