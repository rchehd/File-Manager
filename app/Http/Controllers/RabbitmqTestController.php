<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqTestController extends Controller
{
    public function testConnection()
    {
        try {
            // Підключення до RabbitMQ
            $connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST', '192.168.147.85'),
                env('RABBITMQ_PORT', 5672),
                env('RABBITMQ_USER', 'guest'),
                env('RABBITMQ_PASSWORD', 'guest'),
                env('RABBITMQ_VHOST', '/')
            );

            // Якщо підключення успішне
            return response()->json(['status' => 'connected to RabbitMQ!']);
        } catch (\Exception $e) {
            // Якщо сталася помилка
            return response()->json(['error' => '192.168.147.85 5672 Could not connect to RabbitMQ: ' . $e->getMessage()]);
        }
    }
}
