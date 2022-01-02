<template>
     <div class="p-0 my-2 mx-0 row row_submit color_placeholder_white">
      <div class="col-12 pb-2" :class="{'color_placeholder_red' : token.error , 'color_placeholder_white' : true}">
          <input ref="tokenInput" type="text" :class="{'form-control w-100' : true, 'is-invalid' : token.error }" v-model="token.value"  :placeholder="token.error || 'Spara un qualsiasi biglietto del pacco' " required autofocus>
    </div>
      <div class="col-12"><button class="w-100" @click.prevent="submitData()">Inserisci in Magazzino</button></div>
  </div>
  
</template>
<script>
import { manipulateDatas } from "../../../../../mixins/manipulateDatas.js"
export default {
    mixins : [manipulateDatas],
    data(){
        return{
            token : {
                value : '',
                error : false
            },
            dataToSubmit : ['token']
        }
    },
    mounted()
    {
        this.$nextTick(() => this.$refs.tokenInput.focus())
        this.$parent.comeBack = '/contabilizza/' + this.$parent.tobacco_shop.id

    },
    methods : {
          submitDataFrontEnd()
        {
            this.token.value = ""
            
            this.$nextTick(() => this.$refs.tokenInput.focus()) 

        },
        handleError(errors)
        {
            this.$nextTick(() => this.$refs.tokenInput.focus()) 
            this.getErrorsFromBackEnd(errors.response.data, this);
        },
        submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if(this.token.value.length !=  16) this.token.error = "Reinserisci il codice"

            if( this.thereAreErrors(this.dataToSubmit) )
            {
                this.$nextTick(() => this.$refs.tokenInput.focus()) 
                return
            }
            
            axios
                .post('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins/store' , this.getDatasFormatted(this.dataToSubmit))
                .then(response => (this.submitDataFrontEnd(response.data) ))
                .catch(errors => this.handleError(errors))
        }
    }
}
</script>