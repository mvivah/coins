<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Opportunity;
class OpportunityCreated extends Notification
{
    use Queueable;
    public $opportunity;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Opportunity $opportunity)
    {
       $this->opportunity = $opportunity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New opportunity created')
                    ->greeting('Hello!')
                    ->line('You have a new opportunity for your team.')
                    ->action('View Opportunity', url('/opportunities/'.$this->opportunity->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
