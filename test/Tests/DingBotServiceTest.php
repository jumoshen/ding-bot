<?php

namespace Tests;

use DingBot\Services\DingBotService;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;

class DingBotServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testText()
    {
        (new DingBotService('your access_token'))->text('这是个测试', [], function(MessageInterface $result){
            # do your callback
        });
    }

    /**
     * @throws \Exception
     */
    public function testMarkDown()
    {
        (new DingBotService(''))->markdown('- title', [], function(MessageInterface $result){
            # do your callback
        });
    }
}