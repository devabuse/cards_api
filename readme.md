# Cards API

The idea is someone wants to send someone else a card and would then subscribe to have a card send with a personal message. I created the backend application of storing these subscriptions and providing an admin backend for our client. The client would create a card with the provided personal message and send it, this was provided as a free service over cristmas and has since been taken offline. The backend part is provided as is and still functions. I am certain it can be adapted as base for other forms of APIs, as in my opinion it is a solid base created using Silex

The frontend application for the API is no longer available. The backend API was created early in 2014, it still used PSR-0 :D and I may been slacking a bit on the commenting here and there.

## Installation

Create a copy of default.settings.local.php in the config directory and provide your database credentials and admin password in sha256 (defaults to test)
From your terminal run: php console.php doctrine:schema:load to import the database schema

## Usage

***Creating cards***

```
curl -H "Content-Type: application/json" -X POST -d '{ "receiver": { "name": "Mike", "email": "mike@test.com" }, "sender": { "name": "Erik", "email": "erik@test.com" }, "message" : "You are awesome!" }' cards.dev/api/card

In your case the url used might differ from cards.dev/api/card
```

***Viewing cards***
In your browser go to cards.dev/api/card/hash (base url might differ in your case)

***Admin panel***
- cards.dev/login
- login with credentials (defaults to: admin and password: test)
- View dashboard of cards


