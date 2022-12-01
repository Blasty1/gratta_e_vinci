<template>
       <table class="table" id="contabilita_table">
                    <link rel="stylesheet" href="/css/main/magazzino.css">

  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Token</th>
      <th scope="col">Biglietti Rimanenti</th>
      <th scope="col">Data Acquisto</th>
      <th scope="col" v-if="$parent.$parent.user_logged.id === $parent.$parent.tobacco_shop.user_id"></th>
      <th scope="col" v-if="$parent.$parent.user_logged.id === $parent.$parent.tobacco_shop.user_id"></th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, key) in packagesInSelling" :key="key">
      <td>{{ scratchAndWin.name }}</td>
      <td>{{scratchAndWin.tokenPackage}}</td>
      <td><a tabindex="0" class="" role="button"  data-toggle="popover" data-trigger="focus" data-placement="top" title="Numeri Biglietti Rimanenti" :data-content="Object.values(scratchAndWin.numbersOfPackageNotSold).join(' - ')"> <span class="link_items_in_selling">{{  Math.abs( scratchAndWin.itemsInSelling)  }}</span></a></td>
      <td>{{ moment(scratchAndWin.created_at).format('D/M/Y') }}</td>
      <td @click="completePackage(scratchAndWin.tokenPackage,key)" v-if="$parent.$parent.user_logged.id === $parent.$parent.tobacco_shop.user_id" role="button">&#10003</td>
      <td @click="deletePackage(scratchAndWin.idPackage, key)" v-if="$parent.$parent.user_logged.id === $parent.$parent.tobacco_shop.user_id" role="button">&times</td>

    </tr>
  </tbody >
  <div class="col-12 p-0 my-2 mx-0 row row_submit">
            <div class="col-12 p-0">
                <button type="text" class="form-control w-100">
                    Totale Magazzino : {{ this.getTotalSold() }} &#8364;
                </button>
            </div>
  
          
        </div>
 
  
</table>

</template>
<script>
export default {
    data(){
        return {
            'packagesInSelling' : []
        }
    },
    methods : {
        getPackageSold()
        {
            axios
                .get('/api/packages/'+ this.$parent.$parent.tobacco_shop.id + '/inselling')
                .then(response => this.packagesInSelling = response.data)
                .catch(error => console.log(error))
        },
        completePackage(idItem, positionInArray)
        {
            axios
                .get('/api/packages/' + this.$parent.$parent.tobacco_shop.id + '/' +  idItem + '/complete')
                .then(response => this.deletePackageFrontEnd(positionInArray))
                .catch(errors => console.log(errors.data))
        },
        deletePackageFrontEnd(positionOfItemToDelete)
        {
            this.packagesInSelling.splice(positionOfItemToDelete,1)
        },
        deletePackage(idItemsToDelete, positionInArray)
        {
            axios
                .delete('/api/package/' + this.$parent.$parent.tobacco_shop.id + '/' + idItemsToDelete + '')
                .then(response => this.deletePackageFrontEnd(positionInArray))
                .catch(errors => console.log(errors.data))

        },
        getTotalSold() {
            let moneyGot = 0;
            for (let key in this.packagesInSelling) {
                moneyGot += Math.abs(this.packagesInSelling[key].total_money);
            }
            return moneyGot;
        },
       
    },
    mounted(){
        this.getPackageSold()
        $('.popover-dismiss').popover({
          trigger: 'focus'  
      })
        
    },
    updated()
    {
      $(function () {
            $('[data-toggle="popover"]').popover({
                container : 'body'
            })
        })
    }
    
}
</script>