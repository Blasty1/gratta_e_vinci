<template>
    <ul id="buttonImprenditore" class="mx-auto overflow-auto">
        <h4 class="title">Sezione Imprenditore</h4>
        <li v-for="tobacco_shop in tobacco_shops" :key="tobacco_shop.id"><h5 role="button"><a :href="'contabilizza/' + tobacco_shop.id">{{ tobacco_shop.name }}</a></h5></li>
        <h5 class="add_shops py-2 my-3" role="button" >Aggiungi Attività</h5>
    </ul>
</template>
<script>
export default {
    data(){
        return {}
    },
    methods : {

    },
    props : {
        'tobacco_shops'  : Array,
    }
}
</script>