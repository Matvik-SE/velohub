<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Traits\Common;
    use Traits\Relations\HasMany\Products;
    use Traits\Relations\HasMany\Variants;

    protected $name = 'category';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'parent_id',
        'is_active',
        'is_parent',
        'sorting',
        'latin',
        'title',
        'title_short',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'description',
        'images',
        //'features',
        //'parameters',
    ];
    protected $casts = [
        'settings' => 'object',
        'features' => 'object',
        'parameters' => 'object',
        'images' => 'array',
    ];

    public function getLinkAttribute() {
        return route('category.show', ['latin' => $this->latin, 'id' => $this->id]);
    }
}
