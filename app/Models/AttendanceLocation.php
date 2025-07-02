<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLocation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius_meters',
        'is_active',
        'is_primary',
        'description',
    ];
    
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius_meters' => 'integer',
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
    ];
    
    /**
     * Scope a query to only include active locations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to get the primary location.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true)->where('is_active', true);
    }
    
    /**
     * Calculate distance between this location and given coordinates in meters.
     */
    public function distanceToCoordinates(float $latitude, float $longitude): float
    {
        return $this->calculateDistance(
            (float) $this->latitude,
            (float) $this->longitude,
            $latitude,
            $longitude
        );
    }
    
    /**
     * Check if given coordinates are within the allowed radius.
     */
    public function isWithinRadius(float $latitude, float $longitude): bool
    {
        $distance = $this->distanceToCoordinates($latitude, $longitude);
        return $distance <= $this->radius_meters;
    }
    
    /**
     * Calculate distance between two points using Haversine formula.
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // Earth radius in meters
        
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }
    
    /**
     * Get the primary attendance location.
     */
    public static function getPrimaryLocation(): ?self
    {
        return self::primary()->first();
    }
    
    /**
     * Get coordinates as array.
     */
    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
        ];
    }
} 