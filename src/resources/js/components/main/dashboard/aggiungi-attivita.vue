<template>
    <div class="row">
        <div class="col-12">
            <input type="text" :class="{'form-control w-100' : true, 'is-invalid' : name.error}"  v-model="name.value" id="validationServer04" aria-describedby="validationServer04Feedback" required>
             <div id="validationServer04Feedback" class="invalid-feedback">
                {{name.error}}
            </div>
        </div>
        <div class="col-12">
        <select :class="{'form-control w-100'  : true , 'is-invalid' : street_address.error}" id="validationServer05" v-model="street_address.value" aria-describedby="validationServer05Feedback" required>
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
          {{street_address.error}}
      </div>
        </div>
        <div class="col-12"><button class="w-100 buttonSubmit" @click.prevent="submitData()">Invia</button></div>
    </div>
</template>
<script>
import {manipulateDatas}from '../../../mixins/manipulateDatas.js'
export default {
    mixins : [ manipulateDatas],
    data(){
        return {
            name : {
                value : '',
                error : false
            },
            street_address : {
                value : '',
                error : false
            },
            dataToSubmit : ['name', 'street_address']
        }
    },
    methods : {
        submitDataFrontEnd(newTobaccoShop)
        {
            this.$parent.tobacco_shops.unshift(newTobaccoShop)
            this.$parent.aggiungi_attività = false
        },  
    submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if( this.thereAreErrors(this.dataToSubmit) ) return 
            axios
                .post('/api/contabilizza/tobaccoShop/new' , this.getDatasFormatted(this.dataToSubmit))
                .then(response => (this.submitDataFrontEnd(response.data) ))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    }
}
</script>