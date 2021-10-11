require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp, InertiaLink } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const VueApp = createApp({ render: () => h(app, props) });
        VueApp.config.globalProperties.$route = window.route;
        VueApp.provide('$route', window.route);
        VueApp.component('inertia-link', InertiaLink);
        return VueApp.use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});




InertiaProgress.init({ color: '#4B5563' });
