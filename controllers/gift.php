<?php

    class Gift extends Controller
    {

        public function send(){
            $authId = Request::auth('id');
            if(!$authId){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'There is an error about authentication.'
                ]);
                exit;
            }

            if(!Request::has(['gift_id', 'to'])) {
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'Required parameters error.'
                ]);
                exit;
            }

            $giftModel = new GiftModel($authId);
            $giftId = Request::post('gift_id');
            $to = Request::post('to');

            if(!$giftModel->isExistedUser($to)){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'Not found this user for sending a gift.'
                ]);
                exit;
            }

            if(!$giftModel->canUserSentGift($giftId, $to)){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'You can not send a gift to user for a while.'
                ]);
                exit;
            }

            $saveGift = $giftModel->saveSentGift($giftId, $to);

            if(!$saveGift){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'There was an error occurred while sending a gift.'
                ]);
                exit;
            }

            echo json_encode([
                'error' => false,
                'code' => __LINE__,
                'data' => 'Sent a gift sent successfully by you.'
            ]);
            exit;
        }

        public function receive($giftId, $from)
        {
            // TODO: Implement receive() method.
        }

        public function buy($giftId)
        {
            // TODO: Implement buy() method.
        }

    }