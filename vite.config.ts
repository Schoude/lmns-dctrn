import { defineConfig } from 'vite'

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    // outDir: 'public/js/src',
    copyPublicDir: false,
    emptyOutDir: true,
    rollupOptions: {
      input: 'resources/frontend/src/test.ts',
      output: {
        dir: 'public/js/src/',
        entryFileNames(chunkInfo) {
          return `${chunkInfo.name}.js`;
        },
      }
    }
    // lib: {
    //   entry: 'src/index.ts',
    //   formats: [
    //     'es',
    //   ],
    //   fileName: format => `my-library.${format}.js`,
    // },
  },
})
