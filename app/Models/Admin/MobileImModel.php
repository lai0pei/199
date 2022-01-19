<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: MobileImModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Saturday, 25th December 2021 9:12:27 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MobileImModel extends CommonModel implements ToCollection, WithChunkReading
{
    use Importable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vip_mobile';

    public function __construct()
    {
        ini_set('max_execution_time', 10000);
        ini_set('memory_limit', -1);
    }
    /**
     *  导入用户手机号
     *
     * @param  mixed $collection
     *
     * @return bool
     */
    public function collection(Collection $collection): bool
    {
        DB::beginTransaction();
        try {
            $count = 0;
            $error = 0;
            $time = now();
            foreach ($collection as $v) {
                if ($v[0] === null) {
                    continue;
                }
                if (! preg_match('/^[0-9_]+$/i', $v[0])) {
                    $error++;
                    continue;
                }
                $data[$count] = [
                    'mobile' => $v[0],
                    'created_at' => $time,
                    'updated_at' => $time,
                ];
                $count++;
                if ($count > 10000) {
                    self::insert($data);
                    DB::commit();
                    $data = [];
                    $count = 0;
                }
            }

            if ($data !== []) {
                self::insert($data);
                DB::commit();
            }
        } catch (LogicException $e) {
            throw new LogicException($e->getMessage());
        }

        return true;
    }

    /**
     * 每次导入读取数量
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 50000;
    }
}
