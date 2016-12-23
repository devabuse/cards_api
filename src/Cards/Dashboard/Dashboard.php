<?php

namespace Cards\Dashboard;

use Doctrine\DBAL\Connection;

class Dashboard
{
    private $user;
    private $db;
    private $data;

    /**
     * Dashboard constructor.
     * @param $token
     * @param $db
     */
    public function __construct($token, $db) {
        $this->user = $token->getUser();
        $this->db = $db;
    }

    /**
     * Returns the data for use in the dashboard
     *
     * @return array
     */
    public function getData()
    {
        $this->data = $this->db->fetchAll($this->getQuery(), [], [Connection::PARAM_STR_ARRAY]);

        return $this->data;
    }

    /**
     * Returns total amount of cards
     *
     * @return int
     */
    public function getCount() {
        return count($this->data);
    }

    /**
     * Return the query for getting data for the dashboard
     *
     * @return string
     */
    private function getQuery() {
        return "SELECT r.name as receiver_name, r.email as receiver_email, s.name as sender_name, s.email as sender_email, c.message, c.timestamp
            FROM card c
            LEFT JOIN receiver r ON c.rid = r.id
            LEFT JOIN sender s ON c.sid = s.id
            ORDER BY timestamp DESC";
    }
}