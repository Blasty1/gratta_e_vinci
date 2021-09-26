<template>
    <div>
        <div id="inputsForDates">
            <div class="boxSelezionaDate">
                <p for="start">Inizio Periodo</p>
                <input type="date" name="start" v-model="start.value" :max="moment().format('y-MM-DD')">
            </div>
            <div class="boxSelezionaDate">
                <p for="finish">Fine Periodo</p>
                <input type="date" name="finish" v-model="finish.value" :max="moment().format('y-MM-DD')" :min="start.value">
            </div>
            <div class="boxSelezionaDate">
                <p for="giorni_mesi_settimane">Come vuoi raggruppare</p>
                <select name="giorni_mesi_settimane" v-model="groupBy.value">
                    <option value="d">Giorno</option>
                    <option value="W">Settimana</option>
                    <option value="M">Mese</option>
                </select>
            </div>
        </div>
     <contabilita_template :scratch_and_wins_sold_api="scratchAndWinsSelected" class="changeMaxHeight"></contabilita_template>
    </div>
</template>
<script>
import contabilita_template from './contabilita_template.vue'
import { manipulateDatas } from "../../../../../mixins/manipulateDatas.js"
export default {
  components: { contabilita_template },
  mixins : [manipulateDatas],
    data()
    {
        return {
            start : {
                value : null,
                error : false
            },
            finish : {
                value : null,
                error : false
            },
            groupBy : {
                value : null,
                error : false
            },
            dataToSubmit : ['start','finish','groupBy'],
            scratchAndWinsSelected : {}
        }
    },
    watch : {
        'start.value' :function(){
            if( !this.start.value || !this.finish.value || !this.groupBy.value) return
            
            axios
                .post('/api/contabilita/' + this.$parent.tobacco_shop.id +'/custom', this.getDatasFormatted(this.dataToSubmit))
                .then( response => this.scratchAndWinsSelected = response.data)
                .catch(error => console.log(error))
        },
        'finish.value' :function(){
            if( !this.start.value || !this.finish.value || !this.groupBy.value) return
            
            axios
                .post('/api/contabilita/' + this.$parent.tobacco_shop.id +'/custom', this.getDatasFormatted(this.dataToSubmit))
                .then(response =>this.scratchAndWinsSelected = response.data)
                .catch(error => console.log(error))
        },
        'groupBy.value' :function(){
            if( !this.start.value || !this.finish.value || !this.groupBy.value) return
            
            axios
                .post('/api/contabilita/' + this.$parent.tobacco_shop.id +'/custom', this.getDatasFormatted(this.dataToSubmit))
                .then(response =>this.scratchAndWinsSelected = response.data)
                .catch(error => console.log(error))
        },
        


    }

}
</script>