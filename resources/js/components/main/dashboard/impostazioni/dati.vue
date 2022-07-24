<template>
  <div class="form-row">
    <div class="col-md-12 mb-3">
        <label for="validationServer01">Email</label>
      <input type="email" :class="{'form-control' : true, 'is-invalid' : email.error}"  v-model="email.value" id="validationServer01" placeholder="Email" required>
      <div id="validationServer01Feedback" class="invalid-feedback">
          {{email.error}}
      </div>
    </div>
    <div class="col-md-6 mb-3">
              <label for="validationServer02">Nome</label>
      <input type="text" :class="{'form-control mr-0' : true, 'is-invalid' : name.error}" v-model="name.value" id="validationServer02" placeholder="Nome" required>
      <div id="validationServer02Feedback" class="invalid-feedback">
          {{name.error}}
      </div>
    </div>
    <div class="col-md-6 mb-3">
              <label for="validationServer03">Cognome</label>
         <input type="text" :class="{'form-control mx-0' : true, 'is-invalid' : surname.error}" id="validationServer03" v-model="surname.value" placeholder="Cognome" required>
      <div id="validationServer03Feedback" class="invalid-feedback">
          {{surname.error}}
      </div>
    </div>
     <div class="col-md-12 mb-3">
              <label for="validationServer05">Indirizzo</label>
      <select :class="{'custom-select' : true, 'is-invalid' : street_address.error}" v-model="street_address.value" id="validationServer05" aria-describedby="validationServer04Feedback" required>
        <option selected disabled value="">Provincia</option>
        <option value="Agrigento">Agrigento</option>
        <option value="Alessandria">Alessandria</option>
        <option value="Ancona">Ancona</option>
        <option value="Aosta">Aosta</option>
        <option value="Aquila">Aquila</option>
        <option value="Arezzo">Arezzo</option>
        <option value="Ascoli Piceno">Ascoli Piceno</option>
        <option value="Asti">Asti</option>
        <option value="Avellino">Avellino</option>
        <option value="Bari">Bari</option>
        <option value="Belluno">Belluno</option>
        <option value="Benevento">Benevento</option>
        <option value="Bergamo">Bergamo</option>
        <option value="Biella">Biella</option>
        <option value="Bologna">Bologna</option>
        <option value="Bolzano">Bolzano</option>
        <option value="Brescia">Brescia</option>
        <option value="Brindisi">Brindisi</option>
        <option value="Cagliari">Cagliari</option>
        <option value="Caltanissetta">Caltanissetta</option>
        <option value="Campobasso">Campobasso</option>
        <option value="Caserta">Caserta</option>
        <option value="Catania">Catania</option>
        <option value="Catanzaro">Catanzaro</option>
        <option value="Chieti">Chieti</option>
        <option value="Como">Como</option>
        <option value="Cosenza">Cosenza</option>
        <option value="Cremona">Cremona</option>
        <option value="Crotone">Crotone</option>
        <option value="Cuneo">Cuneo</option>
        <option value="Enna">Enna</option>
        <option value="Ferrara">Ferrara</option>
        <option value="Firenze">Firenze</option>
        <option value="Foggia">Foggia</option>
        <option value="Forlì e Cesena">Forl&igrave; e Cesena</option>
        <option value="Frosinone">Frosinone</option>
        <option value="Genova">Genova</option>
        <option value="Gorizia">Gorizia</option>
        <option value="Grosseto">Grosseto</option>
        <option value="Imperia">Imperia</option>
        <option value="Isernia">Isernia</option>
        <option value="La Spezia">La Spezia</option>
        <option value="Latina">Latina</option>
        <option value="Lecce">Lecce</option>
        <option value="Lecco">Lecco</option>
        <option value="Livorno">Livorno</option>
        <option value="Lodi">Lodi</option>
        <option value="Lucca">Lucca</option>
        <option value="Macerata">Macerata</option>
        <option value="Mantova">Mantova</option>
        <option value="Massa-Carrara">Massa-Carrara</option>
        <option value="Matera">Matera</option>
        <option value="Messina">Messina</option>
        <option value="Milano">Milano</option>
        <option value="Modena">Modena</option>
        <option value="Napoli">Napoli</option>
        <option value="Novara">Novara</option>
        <option value="Nuoro">Nuoro</option>
        <option value="Oristano">Oristano</option>
        <option value="Padova">Padova</option>
        <option value="Palermo">Palermo</option>
        <option value="Parma">Parma</option>
        <option value="Pavia">Pavia</option>
        <option value="Perugia">Perugia</option>
        <option value="Pesaro e Urbino">Pesaro e Urbino</option>
        <option value="Pescara">Pescara</option>
        <option value="Piacenza">Piacenza</option>
        <option value="Pisa">Pisa</option>
        <option value="Pistoia">Pistoia</option>
        <option value="Pordenone">Pordenone</option>
        <option value="Potenza">Potenza</option>
        <option value="Prato">Prato</option>
        <option value="Ragusa">Ragusa</option>
        <option value="Ravenna">Ravenna</option>
        <option value="Reggio Calabria">Reggio Calabria</option>
        <option value="Reggio Emilia">Reggio Emilia</option>
        <option value="Rieti">Rieti</option>
        <option value="Rimini">Rimini</option>
        <option value="Roma">Roma</option>
        <option value="Rovigo">Rovigo</option>
        <option value="Salerno">Salerno</option>
        <option value="Sassari">Sassari</option>
        <option value="Savona">Savona</option>
        <option value="Siena">Siena</option>
        <option value="Siracusa">Siracusa</option>
        <option value="Sondrio">Sondrio</option>
        <option value="Taranto">Taranto</option>
        <option value="Teramo">Teramo</option>
        <option value="Terni">Terni</option>
        <option value="Torino">Torino</option>
        <option value="Trapani">Trapani</option>
        <option value="Trento">Trento</option>
        <option value="Treviso">Treviso</option>
        <option value="Trieste">Trieste</option>
        <option value="Udine">Udine</option>
        <option value="Varese">Varese</option>
        <option value="Venezia">Venezia</option>
        <option value="Verbano-Cusio-Ossola">Verbano-Cusio-Ossola</option>
        <option value="Vercelli">Vercelli</option>
        <option value="Verona">Verona</option>
        <option value="Vibo Valentia">Vibo Valentia</option>
        <option value="Vicenza">Vicenza</option>
        <option value="Viterbo">Viterbo</option>
      </select>
      <div id="validationServer05Feedback" class="invalid-feedback">
          {{ street_address.error }}
      </div>
    </div>
   <div class="col-12" id="buttonGoogleDiv">
        <button :class="{'btn btn-primary buttonSubmit w-100' : true, 'date_updated' : updated}" type="submit"  @click.prevent="submitData()">{{ updated ? 'Dati Salvati' : 'Modifica' }} </button>
    </div>
  </div>
</template>
<script>
import { manipulateDatas } from "../../../../mixins/manipulateDatas"

export default {
    mixins : [manipulateDatas],
    data()
    {
        return {
            email : { 
                value : this.user.email,
                error : false 
            },
            name : {
                value : this.user.name,
                error : false
            },
            surname : {
                value : this.user.surname,
                error : false
            },
            street_address : {
                value : this.user.street_address.split(" ")[0],
                error : false
            },
            dataToSubmit : ['email','name','surname','street_address'],
            updated : false,

        }
    },
    props : {
        user : Object
    },
    methods : {
        canSubmitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            //check mixin
            this.allDataIsBeenInserted(this.dataToSubmit)
            if( this.email.value.indexOf('@') == -1) this.email.error = 'Inserisci un email corretta'
            if( this.thereAreErrors(this.dataToSubmit) ) return false
            return true
        },
        submitResponseFrontEnd()
        {
            this.updated = true;

            setTimeout(() => this.updated = false,5000)
        },
        submitData()
        {
            if (!this.canSubmitData() ) return 
            axios
                .put('/api/user/update',{...this.getDatasFormatted(this.dataToSubmit)})
                .then(response => (this.submitResponseFrontEnd()))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    }
}
</script>