<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceMarked implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;
    public $cardNumber;
    
    public function __construct($cardNumber) {
        $this->cardNumber = $cardNumber;
    }
    
    public function broadcastOn() {
        // මේ චැනල් එකෙන් තමයි ෆෝන් එකට සිග්නල් එක යන්නේ
        return new Channel('attendance-channel');
    }
}