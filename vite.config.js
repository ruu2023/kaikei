import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/sass/analytics.scss",
                "resources/js/app.js",
                "resources/js/transaction.js",
                "resources/js/settings.js",
            ],
            refresh: true,
        }),
    ],
});
