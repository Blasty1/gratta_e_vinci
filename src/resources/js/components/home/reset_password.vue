<template>
<form id="login">
  <div class="form-row">
     <div class="col-md-12 mb-3">
      <input type="password" :class="{'form-control w-100' : true, 'is-invalid' : password.error }" id="validationServer02" placeholder="Password" v-model="password.value" required>
      <div id="validationServer02Feedback" class="invalid-feedback">
          {{ password.error }}
      </div>
    </div>
     <div class="col-md-12 mb-3">
      <input type="password" :class="{'form-control w-100' : true, 'is-invalid' : password.error }" id="validationServer03" placeholder="Ripeti Password"  v-model="password_confirmation.value" required>
      <div id="validationServer03Feedback" class="invalid-feedback">
          {{ password.error }}
      </div>
    </div>
    <div class="col-12 p-0" id="buttonGoogleDiv">
        <button class="btn btn-primary buttonSubmit w-100" type="submit" @click.prevent="change()">Cambia Password</button>
    </div>
    
  </div>
</form>
</template>
<script>
import { manipulateDatas } from "../../mixins/manipulateDatas.js"

export default {
    mixins : [manipulateDatas],
    data(){
        return {
            'password' : {
                value : '',
                error : false
            }, 
            'password_confirmation' : {
                value : '',
                error : false
            },
            dataToSubmit : [ 'password' , 'password_confirmation']
        }
    }, 
    methods : {
        change()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if(this.password.value.length < 8) this.password.error = 'Inserisci una password con almeno 8 caratteri'
            if( this.password.value != this.password_confirmation.value) this.password.error = "Le due password devono combaciare"
            if( this.thereAreErrors(this.dataToSubmit) ) return 
  this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if(this.password.value.length < 8) this.password.error = 'Inserisci una password con almeno 8 caratteri'
            if( this.thereAreErrors(this.dataToSubmit) ) return 

            axios
                .post('/reset-password',{...this.getDatasFormatted(this.dataToSubmit) , token : this.token , email : this.email})
                .then(response => (window.open('/','_self')))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    },

    props : {
        email : String,
        token : String,
    }
    
}
</script>