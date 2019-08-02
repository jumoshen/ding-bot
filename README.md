# ding-bot
Send message to dingding`s group chat

## 环境要求

- php >= 7.1.3
- laravel >= 5.5

安装

``
shell
composer require jumoshen/ding-bot:^0.1
``

使用

```
text文本
(new DingBotService('your access_token'))->text('这是个测试', [], function(MessageInterface $result){
    # do your callback
});

markdown
(new DingBotService(''))->markdown('- title', [], function(MessageInterface $result){
    # do your callback
});
```