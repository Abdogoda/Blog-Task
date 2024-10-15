<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageControlTrait{
  public function uploadImage(UploadedFile $image, string $directory): ?string{
    if ($image->isValid()) {
    $name = time() . '.' . $image->getClientOriginalExtension();
    $image->storeAs($directory, $name, 'public');
    return $name;
    }
    return null;
  }

  public function deleteImage(string $path): bool{
    if (Storage::disk('public')->exists($path)) {
      return Storage::disk('public')->delete($path);
    }
    return false;
  }
}