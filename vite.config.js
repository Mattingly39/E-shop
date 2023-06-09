import { defineConfig } from 'vite'


// https://vitejs.dev/config/
export default defineConfig({
    build: {
      // generate manifest.json in outDir
      manifest: true,
      rollupOptions: {
        // overwrite default .html entry
        input: './resources/main.js'
      }
    }
  })