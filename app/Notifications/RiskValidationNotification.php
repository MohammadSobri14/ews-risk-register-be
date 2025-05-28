<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Risk;

class RiskValidationNotification extends Notification
{
    use Queueable;

    protected $risk;
    protected $isApproved;
    protected $notes;

    public function __construct(Risk $risk, bool $isApproved, $notes = null)
    {
        $this->risk = $risk;
        $this->isApproved = $isApproved;
        $this->notes = $notes;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.risk_validation', [ 
                'risk' => $this->risk,
                'isApproved' => $this->isApproved,
                'notes' => $this->notes,
            ])
            ->subject($this->isApproved 
                ? "Risk '{$this->risk->name}' Disetujui"
                : "Risk '{$this->risk->name}' Ditolak"
            );
    }


    public function toDatabase($notifiable)
    {
        return [
            'risk_id' => $this->risk->id,
            'name' => $this->risk->name,
            'is_approved' => $this->isApproved,
            'notes' => $this->notes,
            'message' => $this->isApproved
                ? 'Risk disetujui Koordinator Manajemen Risiko.'
                : 'Risk ditolak Koordinator Manajemen Risiko, perlu revisi.',
        ];
    }
}