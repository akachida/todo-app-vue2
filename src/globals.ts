import Vue from 'vue'

Vue.mixin({
  data() {
    return {
      get todoApiUrl() {
        return process.env.VUE_APP_API_URL
      },
    }
  },
})
