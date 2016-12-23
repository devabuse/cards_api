<?php

namespace Cards\Service;

use Cards\Service\ServiceInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceCardPost extends Service implements ServiceInterface {
    private $request;
    private $uniqid;

    /**
     * ServiceCardPost constructor.
     * @param $db
     * @param $cacheServiceProvider
     * @param $request
     */
    public function __construct($db, $cacheServiceProvider, $request) {
        parent::__construct($db, $cacheServiceProvider);

        $this->request = $request;
    }


    public function execute() {
        $data = json_decode($this->request->getContent());

        try {
            $rid = $this->insertReceiver($data->receiver);
            $sid = $this->insertSender($data->sender);
            $this->insertCard($rid, $sid, $data);
        } catch (Exception $e) {
            return ['message' => 'Card could not saved'];
        }

        return [
            'message' => 'Card saved',
            'hash' => $this->uniqid,
            '_links' => [
                'card' => '/api/card/' . $this->uniqid,
            ],
        ];
    }

    public function getCacheID() {
        // no caching for post
    }

    /**
     * Insert receiver of card in DB
     *
     * @param array $receiver
     * @return int
     */
    private function insertReceiver($receiver) {
        $this->db->insert('receiver', [
            'name' => $receiver->name,
            'email' => $receiver->email,
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Insert sender into database
     *
     * @param $sender
     * @return mixed
     */
    private function insertSender($sender) {
        $this->db->insert('sender', [
            'name' => $sender->name,
            'email' => $sender->email,
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Insert card into the database
     *
     * @param $rid
     * @param $sid
     * @param $card
     * @return mixed
     */
    private function insertCard($rid, $sid, $card) {
        $this->uniqid = Uuid::uuid4();

        $this->db->insert('card', [
            'rid' => $rid,
            'sid' => $sid,
            'message' => $card->message,
            'timestamp' => time(),
            'hash' => $this->uniqid,
        ]);

        return $this->db->lastInsertId();
    }
}