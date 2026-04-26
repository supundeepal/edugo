<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // එසැණින් යවන්න
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentScanned implements ShouldBroadcastNow // 👈 මෙතන ShouldBroadcastNow දැම්මා
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cardNumber; // 👈 ස්කෑන් කරන කාඩ් එකේ නම්බර් එක අරන් යන්න

    /**
     * Create a new event instance.
     */
    public function __construct($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // 👈 'gate-scanner' කියන නාලිකාව (Channel) හරහා තමයි පණිවිඩේ යන්නේ
        return [
            new Channel('gate-scanner'),
        ];
    }

    // 👈 JS වලින් ලේසියෙන් අල්ලගන්න Event එකට නමක් දෙනවා
    public function broadcastAs()
    {
        return 'student.scanned';
    }
}