<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EmployeeRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $qrPath;

    public function __construct($employee, $qrPath)
    {
        $this->employee = $employee;
        $this->qrPath = $qrPath;
    }

    public function build()
    {
        return $this->view('emails.employee_registered')
                    ->attach(Storage::path($this->qrPath), [
                        'as' => 'employee_qr.png',
                        'mime' => 'image/png',
                    ]);
    }
}
