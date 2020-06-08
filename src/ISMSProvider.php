<?php 
namespace DGvai\ISMS;

use DGvai\ISMS\Exceptions\ISMSException;
use Illuminate\Support\ServiceProvider;

class ISMSProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->when(ISMSChannel::class)
            ->needs(ISMSClient::class)
            ->give(function(){
                $cfg = config('services.isms');
                if (is_null($cfg)) {
                    throw ISMSException::invalidConfiguration();
                }

                return new ISMSClient(
                    $cfg['token'],
                    $cfg['sid']
                );
            });
    }
}