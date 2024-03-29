# eacpay for discuz

#### 介绍
eacpay for discuz，eacpay针对discuz的支付插件。基于earthcoin区块链开发，使用earthcoin区块链代币eac作为支付介质，和现有支付完全不同。无需支付宝、微信、网银。当然站长接收到的是eac，可以随时到交易所变现。同时对于网站用户有一定要求，要求网站用户要有eac才行。插件本身不提供eac的交易和挖矿。eac的来源：交易购买、设备挖矿获得。

整个支付流程站长都是可控的，无需任何中心化机构审批审核，站长的收入完全匿名，用户的支付隐私得到保护。关键是几乎没有手续费！仅仅收取区块链转账本身费用

插件免费使用，永久开源！

#### 软件架构
基于discuz x3.4进行开发的区块链支付插件，兼容x2版本


#### 安装教程

1.  下载对应语言和编码的插件（SC：简体中文，TS：繁体中文），关于编码请登录自己论坛后台首页查看
2.  下载插件后上传到论坛目录source/plugin下面（将会逐渐上线到discuz应用中心，到时候可以直接在应用中心下载）
3.  登录论坛后台，点击"应用"-->“插件“-->找到Eacpay区块链支付，安装即可
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/161605_c1926bf8_5105092.png "1.png")
4.  安装完成后，点击“设置”，主要的设置项如下：
- EAC定价基准交易所：这个当前基本上是固定的。无需改变;
- 是否允许提现，根据自己论坛运营情况决定是否开启；
- earthcoin区块链浏览器，目前公共分别有：[https://api.eacpay.com:9000](https://api.eacpay.com:9000)和[https://blocks.deveac.com:4000](https://blocks.deveac.com:4000)。站长如果对于公共区块链浏览器不放心，推荐自建区块链浏览器；
- 定价基准币种，目前提供：人民币、美元、欧元可选，一旦选定，请不轻易更改，如果更改请使用不同的充值积分类型。例如：人民币用RMB，美元用USD，欧元用EUR；
- 充值积分类型：该积分类型来至于论坛积分，通过论坛内部的积分体系，完成个各积分类型相互之间的转换；
- 充值比例：就是1元=多少积分类型
- 收款地址：地址来自earthcoin电脑端钱包，或者eacpay的接收生成的地址。这是插件必须要正确填写的，否则不能收到eac。电脑端钱包下载：[https://www.eaczg.com](https://www.eaczg.com)；
- 确认数量：区块链支付后，多少个确认表示支付成功。数量越多，安全性越高，但是支付成功需要的时间越长，建议3-6个即可。
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/161624_f7145d54_5105092.png "2.png")
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/161642_6e0a7371_5105092.png "3.png")
#### 使用说明

1.  用户点击”eacpay区块链支付“输入需要充值的金额，不接受小数，充值金额不受限制，点击”提交“
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/164600_321640e9_5105092.png "1.png")
2.  打开eacpay手机端，扫描出现的支付二维码进行支付，支付完成后，等待系统到Earthcoin区块链网络确认支付，需要1-5分钟左右
![输入图片说明](https://images.gitee.com/uploads/images/2021/1118/210312_0f6bf6da_5105092.png "截屏2021-11-18 20.53.28.png")
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/164652_47afc0a4_5105092.jpeg "3.jpeg")
3.  等待系统确认支付情况，最终完成支付
![输入图片说明](https://images.gitee.com/uploads/images/2021/1118/210350_c90b5309_5105092.png "截屏2021-11-18 20.58.33.png")
4.  点击”eacpay区块链支付“中的提现，输入需要提现的金额，点击”申请提现“
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/165015_d1188dd2_5105092.png "6.png")
5.  站长或者管理员登录论坛后台，在”应用“--->”插件“里面的提现订单。点击订单号，使用eacpay扫描弹出的二维码，点击发送。完成提现支付，点击状态，将其更改为：完成即可。
![输入图片说明](https://images.gitee.com/uploads/images/2021/1024/161659_08546a23_5105092.png "截屏2021-10-24 16.06.55.png")
