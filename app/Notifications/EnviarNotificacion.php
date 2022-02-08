<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarNotificacion extends Notification
{
    use Queueable;


    public $subject;
    public $mensaje;
    public $rutaurl;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $mensaje,$rutaurl)
    {
        //
        $this->subject=$subject;
        $this->mensaje=$mensaje;
        $this->rutaurl=$rutaurl;

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
            ->greeting('Hola ' . $notifiable->name)
            ->subject('ANIM - Notificacion: '.$this->subject)
            ->line('Este mensaje es una notificación del sistema de seguiemito de proyectos de la Agencia Nacional Inmobiliaria Virgilio Barco Vargas.')
            ->line($this->mensaje)
            ->action('Ir al sistema', url(route($this->rutaurl)))
            ->line('')
            ->line('Si no ha recibido este mensaje y no tiene relación con la ANIM o con el sistema de información, puede omitirlo')
            ->salutation('Saludos!!');

        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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
