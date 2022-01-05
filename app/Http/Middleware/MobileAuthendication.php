<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: MobileAuthendication.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Wednesday, 5th January 2022 9:19:12 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MobileAuthendication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        dd($_SERVER);
        dd(request()->ip());
        return $next($request);
    }
}
