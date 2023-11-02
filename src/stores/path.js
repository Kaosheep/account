import { defineStore } from "pinia";
import { ref } from "vue";

export const useCounterStore = defineStore('path', () => {
    const phpURL = process.env.NODE_ENV === 'development' ? 'http://localhost/dashboard/public/php/' : ''
    const pubURL = process.env.NODE_ENV === 'development' ? process.env.BASE_URL : process.env.BASE_URL

    return { phpURL, pubURL }
}
)