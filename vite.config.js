import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    base: "",
    server: {
        cors: {
            origin: "*",
        },
        // https: true
    },
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: "",
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
