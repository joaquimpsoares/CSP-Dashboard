import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 5173,
    hmr: {
      host: process.env.VITE_HMR_HOST || '192.168.88.248',
      port: Number(process.env.VITE_HMR_PORT || 5173),
    },
    cors: {
      origin: process.env.APP_URL || 'http://192.168.88.248:8000',
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
