<?php

namespace App\Console\Commands;

use App\Jobs\FileDeleted;
use App\Jobs\SendFileDeleteEmail;
use Illuminate\Console\Command;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteExpiredFiles extends Command
{
    protected $signature = 'files:delete-expired';
    protected $description = 'Delete files that have expired (older than 24 hours).';

    public function handle()
    {
        // Отримуємо всі файли, які старші за 24 години
        $expiredFiles = File::where('expires_at', '<', Carbon::now())->get();

        foreach ($expiredFiles as $file) {
            $data = [
                'file_name' => $file->name,
                'file_size' => $file->size,
            ];

            // Видаляємо файл
            $deleted = $file->deleteFile();

            if ($deleted) {
                $data['deleted_at'] = now();
                // Відправляємо повідомлення про видалення файлу через RabbitMQ
                try {
                    dispatch(new SendFileDeleteEmail($data))->onQueue('send_email');
                } catch (\Exception $e) {
                    Log::error('Error dispatching file deletion job: ' . $e->getMessage());
                }

                $this->info('Expired files have been deleted.');
            }
            else {
                $this->info('Expired files haven\'t been deleted.');
            }
        }


    }
}
