<?php
namespace App\Traits;
use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\JoinClause;
use Traversable;
use Plank\Metable\Metable;
trait PGSMetable {
	
	use Metable {
        Metable::scopeWhereMeta as scopeWhereYearMeta;
        Metable::scopeWhereMeta as scopeWhereMonthMeta;
        Metable::scopeWhereMeta as scopeWhereDayMeta;
        Metable::scopeWhereMeta as scopeWhereDateMeta;
        Metable::scopeWhereMeta as scopeWhereDateTimeMeta;
        Metable::scopeOrWhereMeta as scopeOrWhereMeta;
    }
     
     public function scopeOrWhereMeta(Builder $q, string $key, $operator, $value = null) {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            // pre($value);
            $q->where('key', $key);
            $q->where('value', $operator, $value);
        });
     }
     
     public function scopeWhereYearMeta(Builder $q, string $key, $operator, $value = null) {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            $q->where('key', $key);
            $q->where(\DB::raw('YEAR(value)'), $operator, $value);
        });
     }
     
     public function scopeWhereMonthMeta(Builder $q, string $key, $operator, $value = null) {
       if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            $q->where('key', $key);
            $q->where(\DB::raw('DATE_FORMAT(value,"%m")'), $operator, $value);
        });
     }
     
     public function scopeWhereDayMeta(Builder $q, string $key, $operator, $value = null) {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            $q->where('key', $key);
            $q->where(\DB::raw('DATE_FORMAT(value,"%d")'), $operator, $value);
        });
     }
     
     public function scopeWhereDateMeta(Builder $q, string $key, $operator, $value = null) {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            $q->where('key', $key);
            $q->where(\DB::raw('DATE(value)'), $operator, $value);
        });
     }
     
     public function scopeWhereDateTimeMeta(Builder $q, string $key, $operator, $value = null) {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        // Convert value to its serialized version for comparison.
        if (!is_string($value)) {
            $value = $this->makeMeta($key, $value)->getRawValue();
        }
        
        $q->whereHas('meta', function (Builder $q) use ($key, $operator, $value) {
            $q->where('key', $key);
            $q->where(\DB::raw('CONVERT(value,DATETIME)'), $operator, $value);
        });
     }
	
}
?>
