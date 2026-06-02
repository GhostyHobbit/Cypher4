<?php
// Create a new file or helper: app/Themes/ThemeRegistry.php
namespace App\Themes;

use App\Models\User;

class ThemeRegistry
{
    public static function getMap(): array
    {
        return [
            'default' => [
                'bg-default'     => '29 33 38',
                'bg-dark'        => '17 19 22',
                'bg-light'       => '46 51 60',
                'text-default'   => '243 234 227',
                'text-light'     => '197 184 176',
                'accent'         => '179 106 51',
                'accent-purple'  => '100 71 140',
            ],
            'grounding' => [
                'bg-default'     => '36 29 27',
                'bg-dark'        => '19 16 15',
                'bg-light'       => '60 50 46',
                'text-default'   => '239 230 223',
                'text-light'     => '197 184 176',
                'accent'         => '132 74 50',
                'accent-purple'  => '132 74 50',
            ],
            'light sage' => [
                'bg-default'     => '248 255 251',
                'bg-dark'        => '168 212 190',
                'bg-light'       => '209 235 220',
                'text-default'   => '11 16 13',
                'text-light'     => '70 79 74',
                'accent'         => '242 176 70',
                'accent-purple'  => '242 176 70',
            ],
            'spring blossom' => [
                'bg-default'     => '255 248 253',
                'bg-dark'        => '241 185 197',
                'bg-light'       => '245 231 234',
                'text-default'   => '16 20 24',
                'text-light'     => '49 56 63',
                'accent'         => '56 164 105',
                'accent-purple'  => '248 221 97',
            ],
        ];
    }

    public static function getColorsForUser(?User $user): array
    {
        $theme = $user?->theme ?? 'default';
        $allThemes = self::getMap();

        return $allThemes[$theme] ?? $allThemes['default'];
    }
}
