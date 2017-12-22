<?php

namespace Pawer\Jobs;

use Illuminate\Bus\Queueable;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $imagePath, $imageContents, $file;

    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function handle()
    {
        $this->imageContents = Storage::disk('public')->get($this->imagePath);
        $this->file = Image::make($this->imageContents);
        $this->resize()
            ->limitColors(255)
            ->encode();
        Storage::disk('public')->put($this->imagePath, (string) $this->file);
    }

    public function resize()
    {
        [$width] = getimagesizefromstring($this->imageContents);
        if($width <= 600) return $this->file;

        $this->file->resize(600, null, function($constraint) {
            $constraint->aspectRatio();
        });
        return $this->file;
    }
}
