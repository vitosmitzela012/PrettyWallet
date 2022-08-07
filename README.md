TRON-靓号采集工具
===============

### 系统说明

- 采集区块链钱包账号跟私钥，账号过滤指定规则尾号的钱包保存

### 在线文档

[https://tronapi.gitbook.io/nice](https://tronapi.gitbook.io/nice)

#### 当前文档编辑时间：2022年8月2日00:20:47

#### 当前系统主要是实现了靓号采集的功能，目前写的脚本支持过滤出钱包尾号为3a-8a的钱包地址，如下所示

- THGGmadtDDVPn4mLT5TF53fSDQTFXtHHHH
- TQRPKcfPC5tZyBvmgd1ArHrfWdAbSCgggg
- TUrSesdmyEU2QqAKgrTNzNVGUu8fbsvvvv
- TVVLCtcuT2KPStR8hdhWr2C8PqUgWFwwww
- TH5AXD68VCuziS1rho8MzonVo5YZyZCCCC
- TGkVguCJpgzztNTuy9rcmPjpzkYo7DUUUU
- TMzVutb18XKWYJHq3Q89P2j9siSEbdCCCC
- TUqkuDL858n6tiYEAD2K6fNKUwwCPBQQQQ

### 代码截图
![image](https://user-images.githubusercontent.com/104345258/182198045-eb04adb8-7fc8-48ba-a5be-e7dc0c520cc5.png)


### 操作管理

#### 方案一：

- 在宝塔面板开启一个url执行的脚本，也可以开启多个，然后访问地址：http://www.你的域名或ip.com/api/nice/choose?num=10000
- 上面域名的num参数为你每次执行脚本生成的钱包地址，16G运行内存每次可以生成1w个。脚本可以多开
- 生成的地址经过规则过滤，最后你可以在 项目根目录/public/address/对应的日期address.txt 里面看到生成的钱包地址。把文件下载到本地，改后缀名为.csv 就可以表格形式查看钱包
- 由于账号稀有程度不同，3a的尾号钱包最容易生成，4a的一小时也能出几个往后的都是需要长时间运行脚本的概率问题了

#### 方案二：

- shell 脚本执行命令
- cd D:\somecode\lianghao-collection & php think nicev2
- 命令行解释：cd D:\somecode\lianghao-collection cd到跟目录 执行php think nicev2 （可以配合配置，推荐宝塔配置，最方便）
- 导入数据库

```sql
DROP TABLE IF EXISTS `fa_address`;
CREATE TABLE `fa_address`
(
    `id`         int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `address`    varchar(50)  DEFAULT NULL COMMENT '地址',
    `privateKey` varchar(100) DEFAULT NULL COMMENT '私钥',
    `type`       varchar(20)  DEFAULT NULL COMMENT '类型',
    `time`       int(10) DEFAULT NULL COMMENT '时间',
    `date`       varchar(50)  DEFAULT NULL COMMENT '日期',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='价值钱包';

```

- shell执行成功以后，就可以在数据库看到对应的钱包地址
- 注意事项：在database.php里面配置好数据库相关配置

### 系统售卖

- 价格：800U
- 服务：包含部署上线，以及远程指导
- 特色：代码开源无加密，可以支持二开，也可以补差定制二开
- 联系方式：纸飞机(Telegram):@laowu2021
