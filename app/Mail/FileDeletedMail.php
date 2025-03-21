<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build email view.
     */
    public function build()
    {
        return $this->subject('File Deleted Notification')
            ->view('emails.file_deleted')
            ->with([
                'file_name' => $this->data['file_name'] ?? null,
                'file_size' => $this->data['file_size'] ?? null,
                'deleted_at' => $this->data['deleted_at'] ?? null
            ]);
    }

}
