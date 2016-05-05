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
                    'data' => 'You can send 1 gift per day to every other users.'
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

        public function myGifts(){
            $authId = Request::auth('id');
            if(!$authId){
                header("Location: /user/login");
                exit;
            }
            $model = new GiftModel($authId);
            /** job for expired gifts - this is here because testing purpose */
            $model->findAndUpdateExpiredRequest();
            /** End */
            $myGifts = $model->getMyGifts();
            $myGiftCounter = $model->myGiftCounter();

            return $this->returnView(compact('myGifts', 'myGiftCounter'), true);
        }

        public function receive()
        {
            $authId = Request::auth('id');
            if(!$authId){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'There is an error about authentication.'
                ]);
                exit;
            }

            if(!Request::has('id')) {
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'Required parameters error.'
                ]);
                exit;
            }

            $giftModel = new GiftModel($authId);
            $id = Request::post('id');

            if(!$giftModel->canUserReceiveGift($id)){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'Expired or already claimed gift.'
                ]);
                exit;
            }

            if(!$giftModel->receiveGift($id)){
                echo json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'System Error: You could not receive gift.'
                ]);
                exit;
            }

            echo json_encode([
                'error' => false,
                'code' => __LINE__,
                'data' => 'You receive the gift successfully.'
            ]);
            exit;
        }

        public function buy($giftId)
        {
            // TODO: Implement buy() method.
        }

        public function truncate()
        {
            $model = new GiftModel(null);
            $model->truncatePivotTable();

            Messages::setMsg("Truncated users__gifts table.", "success");
            header("Location: /user/index");
            exit;
        }

    }