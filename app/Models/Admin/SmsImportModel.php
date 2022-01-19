<?php

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SmsImportModel extends CommonModel implements ToCollection, WithChunkReading
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_apply';

    public function __construct($data = [])
    {
        $this->data = $data;
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', -1);
    }

    /**
     *  导入短信
     *
     * @param  mixed $collection
     *
     * @return bool
     */
    public function collection(Collection $collection): bool
    {
        DB::beginTransaction();
        try {
            $status = $this->data['status'] ?? 0;
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

                $update[$count] = [
                    'state' => $status,
                    'updated_at' => $time,
                ];

                if ((int) $status === 1) {
                    $update[$count]['is_send'] = 1;
                    $update[$count]['send_time'] = $time;
                } elseif ((int) $status === 2) {
                    $update[$count]['is_send'] = 0;
                }

                self::where('id', $v[0])->update($update);
                $count++;

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
