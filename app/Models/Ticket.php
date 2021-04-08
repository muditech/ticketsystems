<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    private $dateDiffSqlFn = 'DATEDIFF(NOW(), created_at)';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'country_id',
        'status_id',
        'priority_id',
        'title',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status() : BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority() : BelongsTo
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getShortTitleAttribute() : string
    {
        return Str::limit($this->title, 30, '...');
    }


    /**
     * @param int $past
     * @return mixed
     */
    public function getOpenDaysAttribute($past = 0)
    {
        return $this->created_at->diffInDays($past);
    }

    /**
     * @return mixed
     */
    public function getLastTenAttribute()
    {
        return $this->orderByDesc('id')->take(10)->get();
    }

    /**
     * @return mixed
     */
    public function getOpenAndHighPriorityLastTenAttribute()
    {
        return $this->whereStatusId(TicketStatus::OPEN)
            ->wherePriorityId(TicketPriority::HIGH)
            ->orderByDesc('id')
            ->take(10)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getMoreThanSevenDaysOpenLastTenAttribute()
    {
        return $this->whereStatusId(TicketStatus::OPEN)
            ->whereRaw("{$this->dateDiffSqlFn} > 7")
            ->orderByOpenDays()
            ->take(10)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getOpenByCountriesLastTenAttribute()
    {
        return $this->with('country:id,name')
            ->selectRaw('count(country_id) as total, country_id')
            ->whereStatusId(TicketStatus::OPEN)
            ->groupBy('country_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
    }

    /**
     * @param $query
     * @param $status_id
     * @return mixed
     */
    public function scopeFilterByStatusId($query, $status_id)
    {
        return $status_id == 0 ? $query : $query->whereStatusId($status_id);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByStatus($query)
    {
        return $query->orderBy('status_id');
    }

    /**
     * @param $query
     * @param string $order
     * @return mixed
     */
    public function scopeOrderByOpenDays($query, $order = 'desc')
    {
        return $query->orderByRaw("{$this->dateDiffSqlFn} {$order}");
    }
}
