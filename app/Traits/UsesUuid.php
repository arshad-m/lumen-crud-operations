<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait UsesUuid
{
    public static function boot()
    {
          parent::boot();
          self::creating(function ($model) {
               $model->id = (string) Uuid::generate(4);
          });
    }

}
?>
