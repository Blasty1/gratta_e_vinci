<template>
    <div id="index" class="overflow-auto">
        <div id="dati">
            <h2 class="title">Dati</h2>
            <dati :user = user></dati>
        </div>
        <div id="" class="mt-2">
            <h2 class="title">Chiudi Attività</h2>
            <tobacco-shops-to-delete :tobacco_shops = user.tobacco_shops></tobacco-shops-to-delete>
        </div>
    </div>
</template>

<script>
import signin from "../../home/signin.vue";
import dati from './impostazioni/dati.vue';
import tobaccoShopsToDelete from './impostazioni/tobaccoShopsToDelete.vue';
export default {
    components: { signin, dati,tobaccoShopsToDelete },
    data() {
        return {};
    },
    props: {
        user: Object
    },
    methods: {
        
    },
    
};
</script>
