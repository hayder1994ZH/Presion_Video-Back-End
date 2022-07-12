<?php 
namespace App\Helpers;

use App\Models\TempFiles;
use Ladumor\OneSignal\OneSignal;

class Utilities{

    public static $imageSize = '';
    public static $audioBucket = '/storage/';
    public static $imageBucket = '/storage/';
    public static $videoBucket = '/storage/';
    
    public static function sendNotifications($keys, $message, $subtitle)
    {
        if(!empty($keys)){
            $fields['include_player_ids'] = $keys;
            $notificationMsg = $message;
            return  OneSignal::sendPush($fields, $notificationMsg, $subtitle);
        }
        return false;
    }
}