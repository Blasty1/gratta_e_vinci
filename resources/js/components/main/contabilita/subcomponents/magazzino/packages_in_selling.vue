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
    <tr v-for="(scratchAndWin, key) in packageInSelling" :key="key">
      <td>{{ key }}</td>
      <td>{{ Math.abs( scratchAndWin.total_money) }}</td>
      <td>{{  Math.abs( scratchAndWin.total_quantity)  }}</td>
      <td>{{ Math.abs( scratchAndWin.total_money_earned.toFixed(2)) }}</td>

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
                .get('/api/packages/inselling')
                .then(response => this.packagesInSelling = response.data)
                .catch(error => console.log(error))
        }
    },
    mounted(){
        this.getPackageSold()
    }
}
</script>