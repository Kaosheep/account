import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'

const imageUrl = `${process.env.BASE_URL}favicon.ico`;

export default defineConfig({
  base: '/accountbook',
  plugins: [
    vue(),
    VitePWA({
      manifest: {
        name: 'My Awesome App',
        short_name: 'MyApp',
        description: 'My Awesome App description',
        theme_color: '#ffffff',
        // icons: [		//添加图标， 注意路径和图像像素正确
        //   {
        //     src: imageUrl,
        //     sizes: '192x192',
        //     type: 'image/png',
        //   },
        //   {
        //     src: imageUrl,
        //     sizes: '512x512',
        //     type: 'image/png',
        //   },
        // ]
      },
      registerType: 'autoUpdate',
      workbox: {
        globPatterns: ['**/*.{js,css,html,ico,png,svg}'],		//缓存相关静态资源
        runtimeCaching: [{		//由于要测试第三方API， 这里配置缓存访问第三方API的资源
          handler: 'CacheFirst',
          urlPattern: /^https:\/\/jsonplaceholder/,		//注意，要修改成要测试的API。请使用正则表达式匹配
          method: 'GET',
          options: {
            cacheName: 'test-external-api',		//创建缓存名称
            expiration: {
              maxEntries: 10,
              maxAgeSeconds: 60 * 60 * 24 * 365 // <== 365 days
            },
            cacheableResponse: {
              statuses: [0, 200]
            }
          }
        }]
      },
      devOptions: {
        enabled: true
      }
    })
  ],
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@import "@/assets/css/style.scss";`
      }
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})

