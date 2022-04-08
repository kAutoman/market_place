<?php
namespace App\Models\Filters;
use Illuminate\Database\Eloquent\Builder;
class Order implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        switch($value) {
            case 1:
                return $builder->orderBy('created_at', 'ASC')->orderBy('priority_until', 'DESC');
            break;
            case 2:
                return $builder->orderBy('created_at', 'DESC')->orderBy('priority_until', 'DESC');
            break;
            case 3:
                return $builder->orderBy('price', 'ASC')->orderBy('priority_until', 'DESC');
            break;
            case 4:
                return $builder->orderBy('price', 'DESC')->orderBy('priority_until', 'DESC');
            break;
        }
    }
}