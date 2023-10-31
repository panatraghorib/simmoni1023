import "../css/main.css";

import { createPinia } from "pinia";
import { useDarkModeStore } from "@/Stores/darkMode.js";
import { darkModeKey } from "@/config.js";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import BaseDivider from "@/Components/BaseDivider.vue";
import FormDatePicker from "@/Components/FormDatePicker.vue";

import "vue-toastification/dist/index.css";
import "sweetalert2/dist/sweetalert2.min.css";

import Toast from "vue-toastification";
import VueSweetalert2 from "vue-sweetalert2";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const pinia = createPinia();

const toastOptions = {
    position: "top",
    timeout: 10000,
    closeOnClick: true,
    pauseOnFocusLoss: false,
    pauseOnHover: false,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
    transition: "Vue-Toastification__bounce",
    maxToasts: 30,
    newestOnTop: true,
    filterToasts: (toasts) => {
        // Keep track of existing types
        const types = {};
        return toasts.reduce((aggToasts, toast) => {
            // Check if type was not seen before
            if (!types[toast.type]) {
                aggToasts.push(toast);
                types[toast.type] = true;
            }
            return aggToasts;
        }, []);
    },
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue, Ziggy)
            .use(VueSweetalert2)
            .use(Toast, toastOptions)
            .component("BaseDivider", BaseDivider)
            .component("DatePicker", FormDatePicker)
            .mount(el);
    },
    progress: {
        // color: "#4B5563",
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,
        // The color of the progress bar...
        color: "#29d",
        // Whether to include the default NProgress styles...
        includeCSS: true,
        // Whether the NProgress spinner will be shown...
        showSpinner: true,
    },
});

const darkModeStore = useDarkModeStore(pinia);

/* Dark mode */
if (
    (!localStorage[darkModeKey] &&
        window.matchMedia("(prefers-color-scheme: dark)").matches) ||
    localStorage[darkModeKey] === "1"
) {
    darkModeStore.set(false);
}
