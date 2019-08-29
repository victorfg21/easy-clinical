<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\ReservaMarcacaoConsulta;

class ReservaHorarioNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $reserva;

    /**
     * Create a new notification instance.
     *
     * @param mixed $horario
     */
    public function __construct(ReservaMarcacaoConsulta $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    /*public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!')
        ;
    }*/

    /*public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'profissional_id' => $this->horario['profissional_id'],
            'data_consulta' => $this->horario['data_consulta'],
            'horario_consulta' => $this->horario['horario_consulta'],
        ]);
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'reserva' => $this->reserva
        ];
    }
}
