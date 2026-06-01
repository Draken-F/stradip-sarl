import { defineConfig } from 'astro/config';
import tailwindcss from '@tailwindcss/vite';
import react from '@astrojs/react';
import node from '@astrojs/node';

// https://astro.build/config
export default defineConfig({
  adapter: node({
    mode: 'standalone',
  }),

  vite: {
    plugins: [tailwindcss()],
    server: {
      allowedHosts: ["seven-shoes-repeat.loca.lt"],
      proxy: {
        '/api': 'http://localhost:8000',
        '/uploads': 'http://localhost:8000',
        '/segment-floor': 'http://localhost:8000'
      }
    }
  },

  integrations: [react()],

  i18n: {
    defaultLocale: "fr",
    locales: ["fr", "en"],
    routing: {
      prefixDefaultLocale: true
    }
  }
});