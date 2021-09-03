<template>
    <ul  id="buttonDipendente" class="mx-auto overflow-auto">
        <h4 class="title">Sezione Dipendente</h4>
        <li v-for="tobacco_shop in tobacco_shops" :key="tobacco_shop.id"><h5><a :href="'contabilizza/' + tobacco_shop.id">{{ tobacco_shop.name }}</a></h5></li>
    </ul>
</template>
<script>
export default {
    data(){
        return {

        }
    },
    methods : {

    },
    props : {
        tobacco_shops : Array
    }
}
</script>