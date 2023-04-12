<template>
<div id="buttonImprenditore">
            <h4 class="title">Sezione Imprenditore</h4>

    <ul  class="mx-auto overflow-auto" v-if="!aggiungi_attività">
        <li v-for="tobacco_shop in tobacco_shops" :key="tobacco_shop.id"><h5 role="button"><a :href="'contabilizza/' + tobacco_shop.id">{{ tobacco_shop.name }}</a></h5></li>
    </ul>
            <h5 class="add_shops py-2 my-3" role="button" v-if="!aggiungi_attività" @click="aggiungi_attività = true">Aggiungi Attività</h5>
    <aggiungi-attivita v-if="aggiungi_attività" ></aggiungi-attivita>
</div>
</template>
<script>

export default {
    data(){
        return {
            aggiungi_attività : false
        }
    },
    methods : {

    },
    props : {
        'tobacco_shops'  : Array,
    }
}
</script>