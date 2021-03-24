 <?php
use Edujugon\PushNotification\PushNotification;
use App\Models\Push_notification;
use App\Models\User;
    function send_notification_FCM($notification_id, $title, $message, $id,$type) {
 
        $accesstoken = env('FCM_KEY');
     
        $URL = 'https://fcm.googleapis.com/fcm/send';
        $post_data = '{
          "to" : "' . $notification_id . '",
          "data" : {
            "body" : "",
            "title" : "' . $title . '",
            "type" : "' . $type . '",
            "id" : "' . $id . '",
            "message" : "' . $message . '",
          },
          "notification" : {
            "body" : "' . $message . '",
            "title" : "' . $title . '",
            "type" : "' . $type . '",
            "id" : "' . $id . '",
            "message" : "' . $message . '",
            "icon" : "new",
            "sound" : "default"
          },
        }';
        //print_r($post_data);die;
     
        $crl = curl_init();
     
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: key='.$accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
     
        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
     
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
     
        $rest = curl_exec($crl);
     
        if ($rest === false) {
          $result_noti = 0;
        } else {
          $result_noti = 1;
        }
        return $rest;
    }

    function sendTo($registration_id, $title, $message, $id,$type) {
 
        $accesstoken = env('FCM_KEY');
     
        $URL = 'https://fcm.googleapis.com/fcm/send';
        $post_data = '{
            "to" : "' . $registration_id . '",
            "data" : {
                "body" : "",
                "title" : "' . $title . '",
                "type" : "' . $type . '",
                "id" : "' . $id . '",
                "message" : "' . $message . '",
            },
            "notification" : {
                "body" : "' . $message . '",
                "title" : "' . $title . '",
                "type" : "' . $type . '",
                "id" : "' . $id . '",
                "message" : "' . $message . '",
                "icon" : "new",
                "sound" : "default"
            },
        }';
        //print_r($post_data);die;
     
        $crl = curl_init();
     
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: key='.$accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
     
        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
     
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
     
        $rest = curl_exec($crl);
     
        if ($rest === false) {
          $result_noti = 0;
        } else {
          $result_noti = 1;
        }
        return $rest;
    }

    // function sendMultiple($notification_ids, $title, $message, $image, $latitude, $longitude, $notificationDate) {
    function sendMultiple($notification_ids, $title, $message, $image = '', $notificationType ,$senddata = ''){
        $accesstoken = env('FCM_KEY');
        $URL = 'https://fcm.googleapis.com/fcm/send';
        try {
            $post_data = array(
                'notification' => array(
                        'title' => $title,
                        'body'  => $message,
                        'sound' => 'default'
                    ),
                "data" => array(
                    "title" => $title,
                    "body" =>  $message,
                    "image" =>  $image,
                    "notificationType" =>  $notificationType,
                    "senddata" =>  $senddata,
                    "icon" =>  "new",
                    "sound" => "default"
                ),
                "registration_ids" => $notification_ids
            );

            $save_notification_data = array('reciver_id' => NULL,'message' => $message , 'notification_data' => NULL,'notification_type' => $notificationType,'booking_id' => NULL,'user_id' => NULL,'provider_id' => NULL);
                
                //$save_notification = Push_notification::create($save_notification_data);
            $save_notification = Push_notification::Create($save_notification_data);

            $post_data = json_encode($post_data);
            //print_r($post_data );die("----");

            $crl = curl_init();
        
            $headr = array();
            $headr[] = 'Content-type: application/json';
            $headr[] = 'Authorization: key='.$accesstoken;
            curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
         
            curl_setopt($crl, CURLOPT_URL, $URL);
            curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
         
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
         
            $rest = curl_exec($crl);
         
            if ($rest === false) {
              $result_noti = 0;
            } else {
              $result_noti = 1;
            }
            return $rest;
        } catch (Exception $e) {
            
        }
    }

    function sendPushnotification($device_token, $title, $message, $data ,$notificationType)
    {
        /*notification type  1=admin approve 2=service request send 3=request accept/reject*/
        $push = new PushNotification('fcm');
        $push->setConfig([
            'priority' => 'high',
            'time_to_live' => 5,
            'dry_run' => false
        ]);
        
        try {
            if($data){
                $notificationData = [
                    'user_id'               =>  isset($data['service_user_id']) ? $data['service_user_id'] : '',
                    'user_name'             =>  isset($data['service_user_name']) ? $data['service_user_name'] : '',
                    'user_email'            =>  isset($data['service_user_email']) ? $data['service_user_email'] : '',
                    'user_contact'          =>  isset($data['service_user_contact']) ? $data['service_user_contact'] : '',
                    'user_long'             =>  isset($data['service_user_longitude']) ? $data['service_user_longitude'] : '',
                    'user_lat'              =>  isset($data['service_user_latitude']) ? $data['service_user_latitude'] : '',
                    'service_price'         =>  isset($data['service_price']) ? $data['service_price'] : '',
                    'booking_id'            =>  isset($data['booking_service_id']) ? $data['booking_service_id'] : '',
                    'service_provide_id'    =>  isset($data['provider_id']) ? $data['provider_id'] : '',
                    'request_status'        =>  isset($data['request_status']) ? $data['request_status'] : '' ,
                    'pickup_latitude'       =>  isset($data['pickup_latitude']) ? $data['pickup_latitude'] : '' ,
                    'pickup_longitude'      =>  isset($data['pickup_longitude']) ? $data['pickup_longitude'] : '' ,
                    'drop_latitude'         =>  isset($data['drop_latitude']) ? $data['drop_latitude'] : '' ,
                    'drop_longitude'        =>  isset($data['drop_longitude']) ? $data['drop_longitude'] : '',
                    'payment_ref_id'        =>  isset($data['payment_ref_id']) ? $data['payment_ref_id']  : ''
                ];
                
                $save_notification_data = array('reciver_id' => NULL,'message' => $message , 'notification_data' => json_encode($notificationData),'notification_type' => $notificationType,'booking_id' => $notificationData['booking_id'],'user_id' => $notificationData['user_id'],'provider_id' => $notificationData['service_provide_id']);
                
                //$save_notification = Push_notification::create($save_notification_data);
                $save_notification = Push_notification::updateOrCreate(
                                ['booking_id' => $notificationData['booking_id']],
                                $save_notification_data
                            );
            }else{
                $notificationData = '';
                $data = User::where('device_token',$device_token)->first();
                $save_notification_data = array('reciver_id' => $data->id ,'message' => $message , 'notification_data' => NULL);
                $save_notification = Push_notification::create($save_notification_data);
            }

            $extraNotificationData = [
                'title'                 => $title,
                'body'                  => $message,
                'sound'                 => 'default',
                'badge'                 => 1,
                'message'               => $notificationData,
                'notificationType'      => $notificationType,
                'click_action'          => 'FLUTTER_NOTIFICATION_CLICK',
            ];

            $push->setMessage([
                'notification' => [
                    'title' => $title,
                    'body'  => $message,
                    'sound' => 'default'
                ],
                'data' =>  $extraNotificationData
            ])
                ->setApiKey(env('FCM_KEY'))
                ->setDevicesToken($device_token)
                ->send();
                //print_r($push->getFeedback());die("---");
        } catch (Exception $e) {

        }
    }

