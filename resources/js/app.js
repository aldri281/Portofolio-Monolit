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
        if (loader) {
            console.log('App mounted, removing loader...');
            loader.style.opacity = '0';
            loader.style.pointerEvents = 'none'; // Prevent blocking clicks during fade
            setTimeout(() => {
                if (loader.parentNode) loader.remove();
                console.log('Loader removed successfully.');
            }, 600);
        }

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
