<?php

namespace Cards\Service;

class ServiceCardGet extends Service implements ServiceInterface
{
    private $cardHash;

    /**
     * ServiceCardGet constructor.
     * @param $db
     * @param $cacheServiceProvider
     * @param $cardHash
     */
    public function __construct($db, $cacheServiceProvider, $cardHash) {
        parent::__construct($db, $cacheServiceProvider);

        $this->cardHash = $cardHash;
    }

    public function execute() {
        if($this->getCache() !== false) {
            $stmt = $this->db->prepare($this->getQuery(), [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
            $stmt->execute([':hash' => $this->cardHash]);

            $data = $stmt->fetch();

            if($data === false) {
                return false;
            }

            $data = $this->formatData($data);
            $this->setCache($data, 7200);
        }

        return $this->getCache();
    }

    public function getCacheID() {
        return 'card_' . $this->cardHash;
    }

    /**
     * Format data for output
     *
     * @param array $data
     * @return array
     */
    private function formatData(array $data) {
        return [
            'receiver' => [
                'name' => $data['receiver_name'],
                'email' => $data['receiver_email'],
            ],
            'sender' => [
                'name' => $data['sender_name'],
                'email' => $data['sender_email'],
            ],
            'message' => $data['message'],
        ];
    }

    /**
     * Get the query string
     *
     * @return string
     */
    private function getQuery() {
        return "SELECT r.name as receiver_name, r.email as receiver_email, s.name as sender_name, s.email as sender_email, c.message, c.hash
            FROM card c
            LEFT JOIN receiver r ON c.rid = r.id
            LEFT JOIN sender s ON c.sid = s.id
            WHERE hash = :hash";
    }
}