<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];
    
    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "system_setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return self::castValue($setting->value, $setting->type);
        });
    }
    
    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): void
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );
        
        // Clear cache
        Cache::forget("system_setting_{$key}");
    }
    
    /**
     * Cast value to appropriate type.
     */
    private static function castValue($value, string $type)
    {
        return match($type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
    
    /**
     * Get all settings for a specific group.
     */
    public static function getGroup(string $group): array
    {
        $settings = self::where('group', $group)->get();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting->key] = self::castValue($setting->value, $setting->type);
        }
        
        return $result;
    }
    
    /**
     * Get default language setting.
     */
    public static function getLanguage(): string
    {
        return self::get('default_language', 'en');
    }
    
    /**
     * Set default language setting.
     */
    public static function setLanguage(string $language): void
    {
        self::set('default_language', $language, 'string', 'localization');
    }
} 