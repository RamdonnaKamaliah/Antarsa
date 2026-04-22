<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimPasswordUser extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Taruh variabel di sini (di luar construct) supaya bisa dibaca Blade
    public $password;
    public $name;

    /**
     * Kita tangkap data dari Controller lewat sini
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Akun ARSA - Password Kamu', // Subjek emailnya
        );
    }

    public function content(): Content
    {
        return new Content(
            // 2. Pastikan nama view ini sesuai dengan file blade yang kamu buat
            view: 'emails.kirim_password', 
        );
    }

    public function attachments(): array
    {
        return [];
    }
}