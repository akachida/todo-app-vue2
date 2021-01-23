<template>
  <div id="app" class="container">
    <transition name="fade">
      <div class="loading-todo" v-show="$store.state.isLoading">
        <b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>
      </div>
    </transition>
    <router-view/>
  </div>
</template>

<style lang="sass">
  @import 'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,400;0,600;0,800;1,200;1,400;1,600;1,800&display=swap'
  @import '@/assets/style/app.sass'
</style>
