import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    title: (title) => `${title} - Portofolio Aldri`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.mount(el);

        // Hide global loader after app is mounted
        const loader = document.getElementById('global-loader');
        const progressBar = document.getElementById('loader-progress-bar');
        
        if (progressBar) {
            progressBar.style.transition = 'width 0.3s ease-out';
            progressBar.style.width = '100%';
        }

        if (loader) {
            console.log('App mounted, completing loader...');
            loader.style.pointerEvents = 'none'; 
            
            // Wait for progress bar to finish before fading out
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    if (loader.parentNode) loader.remove();
                    console.log('Loader removed successfully.');
                }, 600);
            }, 300);
        }

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
