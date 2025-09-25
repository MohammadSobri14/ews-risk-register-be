<?php

namespace App\Notifications;

use App\Models\RiskHandling;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;

class RiskHandlingReviewed extends Notification
{
    use Queueable;

    public function __construct(public RiskHandling $handling) {}

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        $this->handling->load(['handledBy', 'reviewer']);

        $subject = $this->handling->is_approved
            ? 'Risk Management Report Approved'
            : 'Risk Management Report Rejected';

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.risk_handling_reviewed', [
                'handling' => $this->handling,
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'handling_id' => $this->handling->id,
            'risk_id' => $this->handling->risk_id,
            'is_approved' => $this->handling->is_approved,
            'notes' => $this->handling->review_notes,
            'message' => $this->handling->is_approved
                ? 'Risk handling report has been approved by the Health Center Head.'
                : 'Risk handling report was rejected by the Health Center Head and requires revision.',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastAs(): string
    {
        return 'notification-review-handling';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('review-handling');
    }
}
