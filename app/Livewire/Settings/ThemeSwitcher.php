<?php

namespace App\Livewire\Settings;

use App\Themes\ThemeRegistry;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ThemeSwitcher extends Component
{
    public string $currentTheme;

    public function mount(): void
    {
        $this->currentTheme = Auth::user()->theme ?? 'default';
    }

    public function selectTheme($themeName): void
    {
        $themes = ThemeRegistry::getMap();
        if (! array_key_exists($themeName, $themes)) {
            return;
        }

        $user = Auth::user();
        $user->theme = $themeName;
        $user->save();

        $this->currentTheme = $themeName;

        $newColors = $themes[$themeName];
        $this->dispatch('theme-changed', colors: $newColors);
    }

    public function render(): View
    {
        return view('livewire.settings.theme-switcher', [
            'availableThemes' => array_keys(ThemeRegistry::getMap()),
        ]);
    }
}
