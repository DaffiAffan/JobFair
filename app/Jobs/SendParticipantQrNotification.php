<?php

namespace App\Jobs;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // ✅ import QRCode
use App\Mail\ParticipantQrMail;

class SendParticipantQrNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {}

    /**
     * Generate QR code PNG and save to storage.
     */
    private function generateQr(): string
    {
        $filename = $this->participant->id_ticket . '.svg'; // SVG format
        $directory = storage_path("app/public/qrcodes");
        $path = $directory . '/' . $filename;

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $qr = QrCode::format('svg') // ✅ gunakan svg agar tidak butuh imagick
            ->size(400)
            ->errorCorrection('H')
            ->generate($this->participant->id_ticket);

        file_put_contents($path, $qr);

        return $filename;
    }
}
