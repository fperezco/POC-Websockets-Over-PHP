## Websocket over PHP (POC)

Just a POC usgin ratchet websocket over PHP

Notes/Steps

```
symfony new websockets2021

php composer.phar require cboden/ratchet

php composer.phar require symfony/maker-bundle

php bin/console make:command

php composer.phar require messenger
```

Launch the server:

```
php bin/console ServerCommandBasic
```

Send a message from server to clients:

```
php bin/console SendMessageToClientTest
```

To send messages from server to client, I just connect from the server to the server as a client and send a message

