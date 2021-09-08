<template>
     <div id="main_contabilità" class="container">
         <nav-icons></nav-icons>
        <transition name="slide-fade">
   <nav-menu v-if="nav_menu"></nav-menu>
        </transition>
          <component v-bind:is="componentToOpen.name"></component>
     </div>
</template>
<script>
export default {
    data(){
        return {
            componentToOpen : {
              'name' : 'contabilita',
              'parametres' : {}
            },
            nav_menu : false,
            comeBack : '/dashboard'
        }
    },
    methods : {

    },
    props : {
        tobacco_shop : Object,
        user_logged : Object 
    }
}
</script>
<style scoped>
.slide-fade-leave-active {
  transition: all .3s ease;
}
.slide-fade-enter-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>