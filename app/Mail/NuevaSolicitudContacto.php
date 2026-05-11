<?php

namespace App\Mail;

use App\Models\SolicitudContacto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudContacto extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public SolicitudContacto $solicitud;

    public function __construct(SolicitudContacto $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de contacto: ' . $this->solicitud->propiedad->titulo,
            replyTo: [$this->solicitud->email_contacto],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-contacto',
            with: ['solicitud' => $this->solicitud],
        );
    }
}
