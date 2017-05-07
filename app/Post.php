<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File, Image;

/**
 * Class Post
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $image_cover
 * @property string $image_full
 * @property string $tags
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    protected $fillable = ['title', 'body', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function saveImage($file)
    {
        $assetDir = 'images';
        $coverDir = $assetDir . DIRECTORY_SEPARATOR . 'cover';
        $fullDir = $assetDir . DIRECTORY_SEPARATOR . 'full';

        if (!File::exists(public_path($coverDir))) {
            File::makeDirectory(public_path($coverDir), 0775, true);
        }
        if (!File::exists(public_path($fullDir))) {
            File::makeDirectory(public_path($fullDir), 0775, true);
        }

        $coverFile = uniqid('cover_') . '.' . $file->getClientOriginalExtension();
        $fullFile = uniqid('full_') . '.' . $file->getClientOriginalExtension();

        Image::make($file->getRealPath())
            ->resize(640, 480)
            ->save(public_path($coverDir . DIRECTORY_SEPARATOR . $coverFile));

        Image::make($file->getRealPath())
            ->resize(1920, 1200)
            ->save(public_path($fullDir . DIRECTORY_SEPARATOR . $fullFile));

        $this->image_cover = asset($coverDir . DIRECTORY_SEPARATOR . $coverFile);
        $this->image_full = asset($fullDir . DIRECTORY_SEPARATOR . $fullFile);

        return $this;
    }
}
