<?php

$schema = new \Doctrine\DBAL\Schema\Schema();

$post = $schema->createTable('card');
$post->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$post->addColumn('rid', 'integer', array('unsigned' => true));
$post->addColumn('sid', 'integer', array('unsigned' => true));
$post->addColumn('message', 'text');
$post->addColumn('timestamp', 'string', array('length' => 256));
$post->addColumn('hash', 'string', array('length' => 256));
$post->setPrimaryKey(array('id'));

$post = $schema->createTable('receiver');
$post->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$post->addColumn('name', 'string', array('length' => 256));
$post->addColumn('email', 'string', array('length' => 256));
$post->setPrimaryKey(array('id'));

$post = $schema->createTable('sender');
$post->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$post->addColumn('name', 'string', array('length' => 256));
$post->addColumn('email', 'string', array('length' => 256));
$post->setPrimaryKey(array('id'));

return $schema;