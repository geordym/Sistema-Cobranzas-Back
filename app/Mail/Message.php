<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }


    public function build()
    {
        return $this->from('ggeordymm@gmail.com', 'Example')
            ->view('mails.bill')->with(['data' => $this->message]);
    }



    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Factura Electronica',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.bill',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attachments = [];

        // Asegúrate de que $this->message->pdf contiene la ruta o el contenido del archivo PDF
        $pdfPath = $this->message->pdf;

        // Verifica si el archivo existe antes de intentar adjuntarlo
        if (file_exists($pdfPath)) {
            $attachments[] = $pdfPath;
        } else {
            // Puedes manejar el caso en el que el archivo no existe
            // Puedes lanzar una excepción, registrar un error, o tomar alguna otra acción.
            // Por ejemplo: throw new \Exception("El archivo PDF no existe en la ruta proporcionada.");
        }

        return $attachments;
    }


}
