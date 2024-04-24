import { defineConfig } from 'vite'

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    emptyOutDir: false,
    lib: {
      entry: 'src/index.ts',
      formats: [
        'es',
      ],
      fileName: format => `my-library.${format}.js`,
    },
    rollupOptions: {
      external: [
        'lit',
      ],
      output: {
        assetFileNames: (assetInfo) => {
          if (assetInfo.name === 'index.css') return 'my-library.css';
          return assetInfo.name ?? '';
        },
        exports: 'named',
        globals: {
          lit: 'lit',
        },
      }
    }
  },
})
