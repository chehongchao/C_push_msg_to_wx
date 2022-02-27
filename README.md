## 内容列表

- [背景](#背景)
- [安装部署](#安装部署)
- [使用说明](#使用说明)
- [开始消息推送](#开始消息推送)
- [维护者](#维护者)
- [贡献者](#贡献者)
- [使用许可](#使用许可)

## 背景

最近在用服务器跑一个爬虫程序，要求爬取到特定的数据时，立即通知到开发者。但是市面上能推送消息的都是付费的，于是用企业微信的发送消息接口实现了一个免费推送消息到微信的程序。

这个仓库的目标是：
* 帮助**不想付费**或没有**营业执照**的**个人开发者**实现推送消息到个人微信。

## 安装部署

以宝塔面板部署此项目为例（需用到**Redis**，如果不参考下方文档，记得安装）。

步骤如下：

* 第一步：购买服务器并做配置(教程还没写)
* 第二步：安装宝塔面板(教程还没写)
* 第三步：宝塔面板部署此程序(教程还没写)
* 第四步：[获取corpid、corpsecret、agentid、touser](https://github.com/zaocanchishenmo/C_push_msg_to_wx/wiki/%E7%AC%AC%E5%9B%9B%E6%AD%A5%EF%BC%9A%E8%8E%B7%E5%8F%96corpid%E3%80%81corpsecret%E3%80%81agentid%E3%80%81touser)
* 第五步：将corpid、corpsecret添加到本程序的配置文件中(教程还没写)

## 使用说明
你只需要有一个**微信账号**即可实现。
## 开始消息推送

请求方式：GET/POST

请求地址：`https://你的域名/PushMsg/pushmsg`

参数说明：


| 参数 | 是否必须 | 说明 |
| :----: | :----: | :----: |
| agent_id | 是 | 应用的AgentId |
| to_user | 是 | 接收消息的账号 |
| content | 是 | 推送的消息内容 |
| token | 否 | 用于权限验证的口令 |

代码示例：


```dart
<?php

$url = "https://你的域名/PushMsg/pushmsg?agent_id=应用的AgentId&content=推送的消息内容&to_user=接收消息的账号
$pushMsgRes = file_get_contents($url);
echo $pushMsgRes;
```

返回示例：
```dart
//成功
{
	"status": 1,
	"message": "消息推送成功~",
	"data": []
}
```
```dart
//失败
{
	"status": 0,
	"message": "消息推送失败",
	"data": {
		"errcode": 41011,
		"errmsg": "missing agentid, hint: [1645886813173453212608313], from ip: 43.155.108.200, more info at https://open.work.weixin.qq.com/devtool/query?e=41011",
		"msgid": "WpLDpQFMGSE843kRbNhgXd9GjUzw4IQKxjoc3SmrUq5VoEIJEyWU7mbRWLkT6dDPCkFnXAQ4Wl3cHe4hWfqS0Q"
	}
}
```

## 维护者

[@zaocanchishenmo](https://github.com/zaocanchishenmo)。

### 贡献者

感谢以下参与项目的人：

## 使用许可

[MIT](LICENSE) © zaocanchishenmo