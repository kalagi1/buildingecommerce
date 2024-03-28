<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMail;

class SendCustomMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $content;
    protected $title;

    public function __construct($email, $content, $title)
    {
        $this->email = $email;
        $this->content = $content;
        $this->title = $title;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new CustomMail($this->content, $this->title));
    }
}
