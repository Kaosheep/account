import { defineStore } from "pinia";
import { ref } from "vue";

export const useEnvironmentStore = defineStore('environment', () => {
    const publicPath = import.meta.env.DEV ? 'http://localhost/dashboard/public/php/' : '';

  
    return {
      publicPath,
    };
  });