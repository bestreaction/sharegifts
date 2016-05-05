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
                "AND gift_id = :gift_id AND expired_at IS NULL ORDER BY id DESC LIMIT 1");
            $this->bind(':sender_id', $this->userId);
            $this->bind(':receiver_id', $to);
            $this->bind(':gift_id', $giftId);
            $userGifts = $this->single();

            if(empty($userGifts)) {
                return true;
            }

            $sentAt = new DateTime("@".$userGifts['sent_at']);
            $diffForSentAt = $sentAt->diff(new DateTime(CURDATE))->days;

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
            $this->bind(':sent_at', (new DateTime(CURDATE))->getTimestamp());
            $this->execute();

            return $this->lastInsertId();
        }

        public function getMyGifts()
        {
            $this->query("SELECT t1.id, t1.receiver_id, t1.gift_id, t1.sent_at, t1.claim_at, ".
                "t1.expired_at, t2.name, t3.title FROM users__gifts AS t1 ".
                "INNER JOIN users AS t2 ON t1.sender_id = t2.id ".
                "INNER JOIN gifts AS t3 ON t3.id = t1.gift_id ".
                "WHERE t1.receiver_id = :receiver_id ");
            $this->bind(':receiver_id', $this->userId);
            $myGifts = $this->resultSet();

            return $myGifts;
        }

        public function truncatePivotTable()
        {
            $this->query("TRUNCATE TABLE users__gifts");
            return $this->execute();
        }

        public function findAndUpdateExpiredRequest()
        {
            // This is cron job for calculate and update for expired requests.
            $this->query("UPDATE users__gifts SET expired_at = :expired_at  ".
                  "WHERE DATE_ADD(FROM_UNIXTIME(sent_at), INTERVAL 7 day) < '".(new DateTime(CURDATE))->format("Y-m-d H:i:s")."'");
            $this->bind(':expired_at', (new DateTime(CURDATE))->getTimestamp());
            $this->execute();
        }

        public function getActiveRequestCounter()
        {
            $this->query("SELECT COUNT(id) as aggr FROM users__gifts ".
                "WHERE receiver_id = :receiver_id AND claim_at is null AND expired_at is null");
            $this->bind(':receiver_id', $this->userId);
            $counter = $this->single();


            if($counter) {
                return $counter['aggr'];
            } else {
                return 0;
            }
        }

        public function myGiftCounter()
        {
            $this->query("SELECT COUNT(id) as aggr FROM users__gifts ".
                "WHERE receiver_id = :receiver_id AND claim_at is not null");
            $this->bind(':receiver_id', $this->userId);
            $counter = $this->single();


            if($counter) {
                return $counter['aggr'];
            } else {
                return 0;
            }
        }

        public function canUserReceiveGift($id)
        {
            $this->query("SELECT sent_at FROM users__gifts WHERE receiver_id = :receiver_id ".
                "AND id = :id AND expired_at IS NULL AND claim_at IS NULL");
            $this->bind(':receiver_id', $this->userId);
            $this->bind(':id', $id);
            $userGifts = $this->single();

            if($userGifts) {
                return true;
            }

            return false;
        }

        public function receiveGift($id)
        {
            $this->query("UPDATE users__gifts SET claim_at = :claim_at WHERE receiver_id = :receiver_id ".
                "AND id = :id AND expired_at IS NULL AND claim_at IS NULL");
            $this->bind(':claim_at', (new DateTime(CURDATE))->getTimestamp());
            $this->bind(':receiver_id', $this->userId);
            $this->bind(':id', $id);
            $this->execute();

            if($this->affectedRows()) {
                return true;
            }

            return false;
        }
    }