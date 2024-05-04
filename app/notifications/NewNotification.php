<?php



namespace App\notifications;


use Illuminate\Notifications\Notification;
use App\Models\Notification as AppNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;


class NewNotification extends Notification
{
    protected $message;
 	protected $title;
  
  
    public function __construct($message,$title)
    {
        $this->message = $message;
        $this->title = $title;
    }
  
 	  public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $notification = AppNotification::create([
            'title' =>  $this->title,
            'body' => $this->message,
            'user_id' => $notifiable->id,
        ]);
        return (new FcmMessage(notification: new FcmNotification(
                title:  $this->title,
                body: $this->message,
                
            )))
            ->data(['title' =>  $this->title, 'body' =>  $this->message])
            ->custom([
                'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]);
    }

    


}
