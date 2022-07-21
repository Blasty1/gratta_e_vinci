<template>
    <div id="index" class="overflow-auto">
        <div id="dati">
            <h2 class="title">Dati</h2>
            <dati :user = user></dati>
        </div>
        <div id="" class="mt-2">
            <h2 class="title">Dati</h2>
            <dati :user = user></dati>
        </div>
    </div>
</template>

<script>
import signin from "../../home/signin.vue";
import dati from './impostazioni/dati.vue';
export default {
    components: { signin, dati },
    data() {
        return {};
    },
    props: {
        user: Object
    },
    methods: {}
};
</script>
