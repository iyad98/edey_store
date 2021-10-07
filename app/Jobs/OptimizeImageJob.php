<?php

namespace App\Jobs;

use App\Repository\NotificationAppUserRepository;
use App\Services\OptimizeImageService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/*  Models */
/* Repository */

// services

class OptimizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $full_path;
    public $path;
    public $file_name;

    public function __construct($full_path, $path, $file_name)
    {
        $this->full_path = $full_path;
        $this->path = $path;
        $this->file_name = $file_name;

    }


    public function handle()
    {
//        $folder = $this->path;
//        $full_path_dest = $folder . "/" . $this->file_name;
//        try {
//            if (!File::exists($folder)) {
//                File::makeDirectory($folder, 0777);
//            }
//            (new OptimizeImageService())->optimize($this->full_path, $full_path_dest);
//
//        } catch (\Exception $e) {
//
//        } catch (\Error $e) {
//
//        }

        File::put(public_path('')."/temp/$this->file_name" , file_get_contents(env('AWS_ENDPOINT_BUCKET').$this->full_path));
        $source = public_path('')."/temp/$this->file_name";
        (new OptimizeImageService())->optimize($source , $this->path);
        File::delete($source);
    }
}
