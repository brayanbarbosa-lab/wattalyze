<?php

namespace App\Mail;

use App\Models\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function build()
    {
        $severity = $this->alert->severity ?? 'medium';
        $subject = $this->getSubjectBySeverity($severity);

        return $this->view('emails.alert-notification')
                    ->subject($subject)
                    ->with([
                        'alert' => $this->alert,
                        'user' => $this->alert->user,
                        'device' => $this->alert->device,
                        'environment' => $this->alert->environment,
                    ]);
    }

    private function getSubjectBySeverity($severity): string
    {
        return match ($severity) {
            'critical' => '🔴 ALERTA CRÍTICO - ' . $this->alert->title,
            'high' => '🟠 ALERTA ALTO - ' . $this->alert->title,
            'medium' => '🟡 ALERTA MÉDIO - ' . $this->alert->title,
            'low' => '🟢 ALERTA BAIXO - ' . $this->alert->title,
            default => '⚠️ ALERTA - ' . $this->alert->title,
        };
    }
}
