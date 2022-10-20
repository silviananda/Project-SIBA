<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifikasiDosen extends Notification
{
    use Queueable;

    protected $dosen_name;
    protected $pesan;
    protected $url;
    protected $tanggal;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->dosen_name = $data['dosen_name'];
        $this->pesan = $data['pesan'];
        $this->url = $data['url'];
        $this->tanggal = $data['tanggal'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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

    //untuk kirim data
    public function toDatabase($notifiable)
    {
        return [
            'dosen_name' => $this->dosen_name,
            'pesan' => $this->pesan,
            'url' => $this->url,
            'tanggal' => $this->tanggal
        ];
    }
}
