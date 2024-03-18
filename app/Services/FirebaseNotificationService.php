<?php

namespace App\Services;

class FirebaseNotificationService{
     
    public function sendFirebaseNotification(array $data){
        return $this->firebaseConnectionServices($data);
    }
    
     protected function firebaseConnectionServices(array $data){
        $data = [
        'registration_ids' => [$data['token']],
        'notification' => [
                            'title' => $data['title'],
                            'body' => $data['body'],
                            // 'icon' => 'https://diligov.com/fornt_theme/assets/img/testimonials/testimonials-5.jpg',
                            'sound' => 'default'
                        ],
        'data'=> [
                    'type' => 'tapo',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]
        ];
        $response ='';
         $SERVER_API_KEY = config('services.firebase_credentials.server_key');
        $dataString = json_encode($data);
        $headers = ['Authorization: key=' . $SERVER_API_KEY, 'Content-Type: application/json',];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $status = curl_exec($ch);
        $result = json_decode($status, true);
        // the content of response  if 
        // "{"multicast_id":2284394909850634079,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1688090674995021%366093e3366093e3"}]}" 
        \Log::info($result); 
        if($result['success'] ==1){ $response = 'success'; }else{ $response ='failure'; }
        return $response;
    }
}