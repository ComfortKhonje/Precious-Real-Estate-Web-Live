import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    react(),
  ],
  resolve: {
    alias: {
      '#components': path.resolve(__dirname, 'resources/js/components'),
      '#ui': path.resolve(__dirname, 'resources/js/components/ui'),
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
