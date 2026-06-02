<div class="p-6 bg-background-dark rounded-lg w-full shadow-sm">
    <h3 class="text-xl font-bold mb-4 text-text-default">Select Your Theme</h3>

    <div class="grid grid-cols-3 gap-3">
        @foreach($availableThemes as $theme)
            <button type="button"
                    @click="$wire.selectTheme('{{ $theme }}')"
                    class="capitalize p-3 text-sm font-semibold rounded-md border transition-all text-center
                    {{ $currentTheme === $theme
                        ? 'border-accent bg-background-light text-text-default shadow'
                        : 'border-accent/20 bg-background-default text-text-light hover:border-accent' }}">
                {{ $theme }}
            </button>
        @endforeach
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            window.addEventListener('theme-changed', (event) => {
                const colors = event.detail.colors;
                const root = document.documentElement;

                root.style.setProperty('--color-bg-default', colors['bg-default']);
                root.style.setProperty('--color-bg-dark', colors['bg-dark']);
                root.style.setProperty('--color-bg-light', colors['bg-light']);
                root.style.setProperty('--color-text-default', colors['text-default']);
                root.style.setProperty('--color-text-light', colors['text-light']);
                root.style.setProperty('--color-accent', colors['accent']);
                root.style.setProperty('--color-accent-purple', colors['accent-purple']);
            });
        });
    </script>
</div>
