notas websocket 2021

symfony new websockets2021

php composer.phar require cboden/ratchet

php composer.phar require symfony/maker-bundle

php bin/console make:command

php composer.phar require messenger

Launch the server:

php bin/console ServerCommandBasic

enviar un mensaje desde el servidor hacia los clientes

php bin/console SendMessageToClientTest


para enviar mensajes del server al cliente =>

desde el server me conecto al socket como si fuese un cliente
mas y envio un mensaje, estoy pendiente de 
estandarizar la codificacion del destinario y el mensaje
para en un futuro, poder mandar mensajes del server
a todos los clientes conectados clientes entre si de uno 
a otro por privado o a grupos, etc...
