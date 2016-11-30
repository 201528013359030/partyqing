<?php
return  function ($event) {
    if(!isset($event->sender->data['code'])){
        return;
    }
    $response = $event->sender;
    if ($response->data !== null) {
        if($response->data['code']>-1){
            $response->data = [
                'errorCode'=> $response->data['code'],
                'message'=> $response->data['message'],
                ];
        }else{
            $response->data = [
                'status'=>0,
                'result'=>$response->data['data'],
                ];
        }
        $response->statusCode = 200;
    }
}
?>
