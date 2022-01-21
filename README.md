<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 基于 laravel-8 + Vue-2.6 + Layui + Laymini 开发的活动大厅

## 服务器配置
<ol>
<li>laravel - 8</li>
<li>php - 8.0</li>
<li>mysql - 5.7 or mariadb - 10.7</li>
<li>集合开发 - wamp-server - 最新版本</li>
<li>数据库 建议用 utf-8 或者 utf-16 charset 和 collation</li>
</ol>

## php - 扩展

<ol>
<li>用wamp-server 基本都已有安装</li>
<li>PHP >= 7.3</li>
<li>BCMath PHP Extension</li>
<li>Ctype PHP Extension</li>
<li>Fileinfo PHP Extension</li>
<li>JSON PHP Extension</li>
<li>Mbstring PHP Extension</li>
<li>OpenSSL PHP Extension </li>
<li>PDO PHP Extension</li>
<li>Tokenizer PHP Extension</li>
<li>XML PHP Extension</li>
</ol>

## 安装 图片压缩 系统包
暂时 只有linux 包。根据自己的 系统类型 更换指令. 不安装 也不影响 项目运行.
```bash
sudo yum install jpegoptim
sudo yum install optipng
sudo yum install pngquant
sudo yum install gifsicle
sudo yum install webp
sudo npm install -g svgo@1.3.2  ->  这个不需要，npm 是nodejs 指令 所有系统 都一致。
```

## 本地测试安装 
<ol>
<li>进入 项目 目录， 打开terminal.</li>
<li>composer install - 安装 包, 必须先安装 composer</li>
<li>cp .env.example .env - 拷贝一个 配置文件. 数据库 配置在这里</li>
```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve -> 本地后台运行 
npm install
npm run hot -> 本地前台运行
```
<li>运行 需要两个 terminal </li>
</ol>

## 服务器安装
<ul>
<li>服务器 默认是 root . 用root 账号 安装 会有权限 问题</li>
<li>建议 配置里加入 www 账号登录, 文件位置 - /etc/passwd. 里面 www :/sbin/nologin 换成 => :/bin/bash</li>
<li>可以参考 文件里其他用户的 Login bash. 如果要限制登录 换回来即可</li>
</ul>

1.进入 项目 目录， 打开terminal, 然后 登录 www 账号
```bash
su www
composer install - 安装 包, 必须先安装 composer
cp .env.example .env - 拷贝一个 配置文件. 数据库 配置在这里
php artisan key:generate
php artisan migrate --seed. (没在运行这个指令之前 需要先安装 数据库. 账号密码端口 在.env 里配置好.
```
<ul>
<li>2.服务器 一般 用 nginx 或 apache . nginx 服务器 配置 laravel 官网提供 文档 (https://laravel.com/docs/8.x/deployment)</li>
<li>3.缓存 配置, 路由, 前台blade文件, 一下 指令 ，复制粘贴 在项目目录的 terminal 里</li>
</ul>
```bash
composer install --optimize-autoloader --no-dev ( 优化 composer 包。减少找包的时间)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
4.更新 config 目录下的文件, route 目录下文件, resource目录 view 下的文件 后 都需要 清除缓存。 根据更新的 文件 选择指令
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
5.或者 全部清除
```bash
php artisan cache:clear
```
6.前台必须 打包 ，在本地或者 在服务器里 打包都行
```bash
npm install  - 安装 npm 包
npm run production - 打包
```

## 后台登录
<ul>
<li>链接 - localhost:8080/6ucwfN@Bt</li>
<li>账号 - admin 密码 123456</li>
</ul>

## 前台登录
localhost:8080


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
