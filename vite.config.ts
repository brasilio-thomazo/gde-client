import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/scss/main.scss', 'resources/ts/main.ts'],
      refresh: true,
    }),
    vue(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/ts'),
      '@views': path.resolve(__dirname, 'resources/ts/views'),
      '@store': path.resolve(__dirname, 'resources/ts/store'),
      '@components': path.resolve(__dirname, 'resources/ts/components'),
    },
  },
  server: {
    host: '0.0.0.0',
    port: 3001,
    hmr: {
      host: 'localhost',
    },
  },
})
