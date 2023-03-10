<?php

namespace IngressITSolutions\Ultim8eBlogger\Models;

use Carbon\Carbon;
use IngressITSolutions\Ultim8eBlogger\Repositories\PostRepository;
use IngressITSolutions\Ultim8eBlogger\Services\Model;

class Post extends Model
{
    public function getRouteKey(): string
    {
        return $this->slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getUrlAttribute(): string
    {
        return route('ultim8e-blogger.show', $this->slug);
    }

    public function getDateAttribute(): Carbon
    {
        return Carbon::parse($this->attributes['date']);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(
            [app(PostRepository::class), $name],
            $arguments
        );
    }
}
