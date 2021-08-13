<?php

namespace App\Models;

use App\Exceptions\UnexpectedImageDataException;
use ErrorException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasUuidAsPrimary, HasFactory;

    protected $fillable = [
        'data',
    ];

    /**
     * @throws \App\Exceptions\UnexpectedImageDataException
     */
    public function getType(): string
    {
        try {
            $uri = 'data://application/octet-stream;base64,' . $this->data;
            $info = getimagesize($uri);

            return $info['mime'];
        } catch (ErrorException $e) {
            throw new UnexpectedImageDataException($e);
        }
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
