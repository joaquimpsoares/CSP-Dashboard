import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: true, // listen on 0.0.0.0 so devices on LAN can load dev assets
    port: 5173,
    hmr: {
      host: process.env.VITE_HMR_HOST || undefined,
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
