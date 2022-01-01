<template>
       <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Token</th>
      <th scope="col">Biglietti Rimanenti</th>
      <th scope="col">Data Acquisto</th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, key) in packagesInSelling" :key="key">
      <td>{{ scratchAndWin.name }}</td>
      <td>{{ scratchAndWin.tokenPackage }}</td>
      <td>{{  Math.abs( scratchAndWin.itemsInSelling)  }}</td>
      <td>{{ moment(scratchAndWin.created_at).format('D/M/Y') }}</td>

    </tr>
  </tbody >
 
  
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
        }
    },
    mounted(){
        this.getPackageSold()
    }
}
</script>