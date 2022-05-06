<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeatherAlert extends Notification
{
    use Queueable;

    private $settings;
    public $finalWeatherMain;
    public $finalWeatherDescription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($finalWeatherMain, $finalWeatherDescription)
    {

        $this->finalWeatherMain = $finalWeatherMain;
        $this->finalWeatherDescription = $finalWeatherDescription;
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
            ->line('It\'s bad weather today!')
            ->action('Notification Action', url('/'))
            ->line($this->finalWeatherMain . ', ' . $this->finalWeatherDescription . '!!!');
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
