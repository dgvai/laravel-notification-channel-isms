<?php 
namespace DGvai\ISMS;

use DGvai\ISMS\Exceptions\InvalidReceiver;
use DGvai\ISMS\Exceptions\ISMSException;
use Illuminate\Notifications\Notification;

class ISMSChannel 
{
    protected $ISMSClient;

    public function __construct(ISMSClient $client)
    {
        $this->ISMSClient = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        try 
        {
            $to = $this->getTo($notifiable);
            $message = $notification->toISMS($notifiable)->message();
            $result = $this->ISMSClient->sendSMS($to, $message);

            if($result->status == 'FAILED')
            {
                throw ISMSException::couldNotSend($result->status_code, $result->error_message);
            }
            else 
            {
                return true;
            }
        } 
        catch(\Exception $ex)
        {
            throw ISMSException::unknownError($ex->getMessage());
        }
    }

    protected function getTo($notifiable)
    {
        if (isset($notifiable->mobile_number)) {
            return $notifiable->mobile_number;
        }
        
        if ($notifiable->routeNotificationFor('ISMS')) {
            return $notifiable->routeNotificationFor('ISMS');
        }

        throw InvalidReceiver::noReceiverSet();
    }
}