<?php

namespace App\Mail;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TagihanMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pembayaran $pembayaran;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Tagihan Sewa Tanah - ' . $this->pembayaran->kontrak->no_kontrak,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tagihan',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
