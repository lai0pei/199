<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 服务配置
1.laravel - 8
2.php - 8.0
3. mysql - 5.7 or mariadb - 10.7
4.集合开发 - wamp-server -最新版本
5.数据库 建议用 utf-8 或者 utf-16 charset 和 collation

## 所需安装
php - 扩展
用wamp-server 基本都已有安装
PHP >= 7.3
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP Extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension 
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension

## 安装 图片压缩 系统包
暂时 只有linux 包。根据自己的 系统类型 更换指令. 不安装 也不影响 项目运行.
```bash
sudo apt-get install jpegoptim
sudo apt-get install optipng
sudo apt-get install pngquant
sudo npm install -g svgo@1.3.2 -> 这个不需要，npm 是nodejs 指令 所有系统 都一致。
sudo apt-get install gifsicle
sudo apt-get install webp
```

## 本地测试安装 
1.进入 项目 目录， 打开terminal.
2.composer install - 安装 包, 必须先安装 composer
3. cp .env.example .env - 拷贝一个 配置文件. 数据库 配置在这里.
```bash
4.php artisan key:generate
5.php artisan migrate --seed
6.php artisan serve - 本地后台运行 
7.npm install
8.npm run hot -> 本地前台运行
```
9.运行 需要两个 terminal 

## 服务器安装
服务器 默认是 root . 用root 账号 安装 会有权限 问题.
建议 配置里加入 www 账号登录, 文件位置 - /etc/passwd. 里面 www :/sbin/nologin 换成 => :/bin/bash. 可以参考 文件里其他用户的 Login bash. 如果要限制登录 换回来即可。
1.进入 项目 目录， 打开terminal, 然后 登录 www 账号. 
```bash
su www
2.composer install - 安装 包, 必须先安装 composer
3. cp .env.example .env - 拷贝一个 配置文件. 数据库 配置在这里.
4.php artisan key:generate
5.php artisan migrate --seed. (没在运行这个指令之前 需要先安装 数据库. 账号密码端口 在.env 里配置好.
```
6.服务器 一般 用 nginx 或 apache . nginx 服务器 配置 laravel 官网提供 文档 (https://laravel.com/docs/8.x/deployment).
7.缓存 配置, 路由, 前台blade文件, 一下 指令 ，复制粘贴 在项目目录的 terminal 里 .
```bash
composer install --optimize-autoloader --no-dev ( 优化 composer 包。减少找包的时间)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
8.更新 config 目录下的文件, route 目录下文件, resource目录 view 下的文件 后 都需要 清除缓存。 根据更新的 文件 选择指令.
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
9.或者 全部清除 
```bash
php artisan cache:clear
```
10.前台必须 打包 ，在本地或者 在服务器里 打包都行.
```bash
npm install  - 安装 npm 包
npm run production - 打包
```

## 后台登录
localhost:8080/6ucwfN@Bt
账号 - admin 密码 123456

## 前台登录
localhost:8080


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
