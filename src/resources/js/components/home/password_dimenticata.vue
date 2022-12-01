<template>
    <form id="login">
  <div class="form-row">
    <div class="col-md-12 mb-3">
      <input type="email" :class="{'form-control w-100' : true, 'is-invalid' : email.error}" id="validationServer01" v-model="email.value" placeholder="Email" required>
      <div id="validationServer01Feedback" class="invalid-feedback">
          {{email.error}}
      </div>
    </div>
    <div class="col-12 p-0" id="buttonGoogleDiv">
        <button class="btn btn-primary buttonSubmit w-100" type="submit" @click.prevent="sendData()">Invia Email di Recupero</button>
    </div>
    
  </div>
</form>
</template>
<script>
import { manipulateDatas } from "../../mixins/manipulateDatas.js"

export default {
    mixins : [ manipulateDatas ],
    data()
    {
        return {
            email : {
                value : '',
                error : false

            }
        }
    }, 
    methods : {
        sendData()
        {
            this.cleanInputErrors(['email'])
            this.allDataIsBeenInserted(['email'])
            if( this.email.value.indexOf('@') == -1) this.email.error = 'Inserisci un email corretta'
            if( this.thereAreErrors(['email']) ) return false
            
            axios
                .post('/api/password/reset',this.getDatasFormatted(['email']))
                .then(response => (window.open('/','_self')))
                .catch(errors => ( this.getErrorsFromBackEnd(errors.response.data, this)))
        }
    }
}
</script>