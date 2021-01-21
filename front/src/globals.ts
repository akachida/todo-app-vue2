import Vue from 'vue'

Vue.mixin({
  data() {
    return {
      get apiUrl() {
        return process.env.VUE_APP_API_URL
      },
    }
  },
})
