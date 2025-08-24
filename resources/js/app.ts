import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

import Toast from '@/components/Toast.vue' // ✅ Import Toast

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// kita butuh variabel global untuk akses toast
let toastRef: any;

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // ✅ mount Toast sekali saja, di luar tree inertia
        const toast = createApp(Toast);
        toastRef = toast.mount(document.createElement('div'));
        document.body.appendChild(toastRef.$el);

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// ✅ global helper biar gampang dipanggil dari view
export function showToast(type: 'success' | 'error', message: string) {
    toastRef.showToast(type, message);
}
