<template>
    <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Prezzo</th>
      <th scope="col">Quantità</th>
      <th scope="col">Venduto da</th>
       <th scope="col">Orario</th>
       <th v-if="$parent.user_logged.id === $parent.tobacco_shop.user_id" ></th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, index) in scratchAndWinSold" :key="index"  :class="{ 'itemsExceptFirst' :  index != 0}">
      <td scope="row">{{scratchAndWin.name}}</td>
      <td>{{ scratchAndWin.prize * scratchAndWin.pivot.quantity }}</td>
      <td>{{  scratchAndWin.pivot.quantity  }}</td>
      <td>{{ ( scratchAndWin.user &&  scratchAndWin.user.name ) || 'Gestore' }}</td>
      <td>{{ moment(scratchAndWin.pivot.created_at).format('LT')  }}</td>
      <td @click="deleteScratchAndWinSold(scratchAndWin.pivot.id, index)" v-if="$parent.user_logged.id === $parent.tobacco_shop.user_id" role="button">&times</td>
    </tr>
  </tbody >
  <div class="col-12 p-0 my-2 mx-0 row row_submit">
      <div class="col-6" :class="{'color_placeholder_red' : token.error}">
          <input ref="tokenInput" type="text" :class="{'form-control w-100' : true, 'is-invalid' : token.error }" id="validationServer01" v-model="token.value" aria-describedby="validationServer03Feedback"  :placeholder="token.error || 'Inserisci il codice seriale del GV' " required autofocus>
    </div>
      <div class="col-2" :class="{'color_placeholder_red' : quantity.error}">
          <input type="number" :class="{'form-control w-100' : true, 'is-invalid' : quantity.error}" id="validationServer03" v-model.number="quantity.value" aria-describedby="validationServer02Feedback" required>
            <div id="validationServer02Feedback" class="invalid-feedback">
                {{quantity.error}}
    </div></div>
      <div class="col-4"><button class="w-100" @click.prevent="submitData()">Invia</button></div>
  </div>
  
</table>
</template>
<script>
import { manipulateDatas } from "../../../../mixins/manipulateDatas.js"

export default {
  mixins : [ manipulateDatas ],
    data(){
        return {
            scratchAndWinSold : [],
            token : {
                value : '',
                error : false 
            },
            quantity : {
                value : 1,
                error : false
            },
            dataToSubmit : ['token','quantity'],
            newEntry : false,
        }
    },
    watch : {
        'token.value' : function(){
            if(this.token.value.length ==  16) this.submitData()
        }
    },
    methods : {
        getScratchAndWinSold()
        {
            axios
                .get('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins')
                .then(response => this.scratchAndWinSold = response.data.reverse())
                .catch(error => console.log(error))
        },
        deleteScratchAndWinSoldFrontEnd(positionOfItemToDelete)
        {
            this.scratchAndWinSold.splice(positionOfItemToDelete,1)
            this.$nextTick(() => this.$refs.tokenInput.focus())        
        },
        deleteScratchAndWinSold(idItemsToDelete, positionInArray)
        {
            axios
                .delete('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins/' + idItemsToDelete + '/delete')
                .then(response => this.deleteScratchAndWinSoldFrontEnd(positionInArray))
                .catch(error => console.log(error.data))

        },
        submitDataFrontEnd(newScratchAndWinSold)
        {
            this.scratchAndWinSold.unshift(newScratchAndWinSold)
            this.token.value = ""
            this.quantity.value = 1
            this.$nextTick(() => this.$refs.tokenInput.focus())        


        },
        submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if( this.thereAreErrors(this.dataToSubmit) ) return 

            axios
                .post('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins/store' , this.getDatasFormatted(this.dataToSubmit))
                .then(response => (this.submitDataFrontEnd(response.data) ))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    },
    mounted(){
        this.getScratchAndWinSold()
    }
}
</script>