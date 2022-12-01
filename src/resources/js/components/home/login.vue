<template>
    <div class="w-100 h-100">
      <password_dimenticata v-show="is_open_password_dimenticata_box"></password_dimenticata>
        <form id="login" v-show="!is_open_password_dimenticata_box">
  <div class="form-row">
    <div class="col-md-12 mb-3">
      <input type="email" :class="{'form-control' : true, 'is-invalid' : email.error}"  id="validationServer01" v-model="email.value" placeholder="Email" required>
      <div id="validationServer01Feedback" class="invalid-feedback">
        {{ email.error }}
      </div>
    </div>
    <div class="col-md-12 mb-3">
      <input type="password" :class="{'form-control' : true, 'is-invalid' : password.error}" id="validationServer02" v-model="password.value" placeholder="Password" required>
      <div id="validationServer02Feedback" class="invalid-feedback">
        {{ password.error }}
      </div>
    </div>
    <div class="col-md-12 text-center">
      <p id="passw_dimenticata" @click="openPasswordDimenticata()" role="button" >Password Dimenticata</p>
    </div>
    <div class="col-12 p-0" id="buttonGoogleDiv">
        <img role="button" src="/imgs/home/button_login.svg" class="" id="buttonGoogle" @click="openGoogleLogin()" alt="" srcset="">
        <button class="btn btn-primary buttonSubmit" type="submit" @click.prevent="submitData()">Entra</button>
    </div>
    
  </div>
</form>
    </div>
</template>
<script>
import { manipulateDatas } from "../../mixins/manipulateDatas.js"

export default {
  mixins : [ manipulateDatas ],
    data(){
        return {
            google_url : '',
            is_open_password_dimenticata_box : false,
            email : {
              value : '',
              error : false
            },
            password : {
              value : '',
              error : false 
            },
            dataToSubmit : [ 'email','password' ]
        }
    },
    props : {
    },
    methods : {
        getLinkLoginGoogle()
        {
            axios
                .get('/api/google/login/url')
                .then(response => this.google_url = response.data )
                .catch( error => console.log(error))
        },
        openGoogleLogin()
        {
            window.open(this.google_url,'_self');
        },
        openPasswordDimenticata()
        {
          this.is_open_password_dimenticata_box = true
        },
        submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if(this.password.value.length < 8) this.password.error = 'Inserisci una password con almeno 8 caratteri'
            if( this.email.value.indexOf('@') == -1) this.email.error = 'Inserisci un email corretta'
            if( this.thereAreErrors(this.dataToSubmit) ) return 

            axios
                .post('/login',this.getDatasFormatted(this.dataToSubmit) )
                .then(response => (window.open('/dashboard','_self')))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    },
    mounted()
    {
        
        this.getLinkLoginGoogle()
    }

}
</script>