<template>
       <table class="table width_100" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Token</th>
      <th scope="col">Data Acquisto</th>
      <th scope="col">Data Termine</th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, key) in packagesSold" :key="key">
      <td>{{ scratchAndWin.name }}</td>
      <td>{{ scratchAndWin.tokenPackage }}</td>
      <td>{{  moment(scratchAndWin.created_at).format('D/M/Y') }}</td>
      <td>{{ moment(scratchAndWin.updated_at).format('D/M/Y') }}</td>

    </tr>
  </tbody >
 
  
</table>
</template>
<script>
export default {
    data(){
        return {
            'packagesSold' : []
        }
    },
    methods : {
        getPackageSold()
        {
            axios
                .get('/api/packages/'+ this.$parent.$parent.tobacco_shop.id + '/sold')
                .then(response => this.packagesSold = response.data)
                .catch(error => console.log(error))
        }
    },
    mounted(){
        this.getPackageSold()
    }
}
</script>