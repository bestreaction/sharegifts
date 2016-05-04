<?php

    class GiftModel extends Model{

        private $userId;

        public function __construct($userId)
        {
            $this->userId = $userId;
            parent::__construct();
        }

        public function isExistedUser($userId)
        {
            $this->query("SELECT COUNT(id) AS aggr FROM users WHERE id = :id");
            $this->bind(":id", $userId);
            $user = $this->single();

            if($user['aggr'] < 1){
                return false;
            }

            return true;
        }

        public function canUserSentGift($giftId, $to)
        {
            $this->query("SELECT sent_at FROM users__gifts WHERE sender_id = :sender_id AND receiver_id = :receiver_id ".
                "AND gift_id = :gift_id AND expired_at IS NULL ORDER BY sent_at DESC LIMIT 1");
            $this->bind(':sender_id', $this->userId);
            $this->bind(':receiver_id', $to);
            $this->bind(':gift_id', $giftId);
            $userGifts = $this->single();

            if(empty($userGifts)) {
                return true;
            }

            $sentAt = new DateTime("@".$userGifts['sent_at']);
            $diffForSentAt = $sentAt->diff(new DateTime())->days;
            
            if($diffForSentAt < 1){
                // User could be sent a gift per day.
                return false;
            }

            return true;
        }

        public function saveSentGift($giftId, $to)
        {
            $this->query("INSERT INTO users__gifts (sender_id, receiver_id, gift_id, sent_at) " .
                "VALUES (:sender_id, :receiver_id, :gift_id, :sent_at)");
            $this->bind(':sender_id', $this->userId);
            $this->bind(':receiver_id', $to);
            $this->bind(':gift_id', $giftId);
            $this->bind(':sent_at', (new DateTime())->getTimestamp());
            $this->execute();

            return $this->lastInsertId();
        }

    }