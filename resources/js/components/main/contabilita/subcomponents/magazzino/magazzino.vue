<template>
    <div class="d-flex flex-md-row flex-column h-100">
        <template v-if="!is_open_packages_in_selling && !is_open_packages_sold">
            <link rel="stylesheet" href="/css/main/magazzino.css">
            <div class="flex-grow-1 d-flex justify-content-center align-items-center "><h1 class="divIniziali" @click="showComponent('in_selling')">Pacchi In Vendita</h1></div>
            <div class="flex-grow-1 d-flex justify-content-center align-items-center "><h1 class="divIniziali" @click="showComponent('sold')">Pacchi Venduti</h1></div>
        </template>
        <packages_in_selling v-if="is_open_packages_in_selling"></packages_in_selling>
        <packages_sold v-if="is_open_packages_sold"></packages_sold>
    </div>
</template>
<script>
import packages_in_selling from './packages_in_selling.vue'
import packages_sold from './packages_sold.vue'
export default {
  components: { packages_in_selling, packages_sold },
    data()
    {
        return {
            is_open_packages_in_selling : false,
            is_open_packages_sold : false
        }
    },

    methods : {
        showComponent : function(nameComponentToShow)
        {
            this['is_open_packages_' + nameComponentToShow] = !this['is_open_packages_' + nameComponentToShow]
        }
    },
}
</script>