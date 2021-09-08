<template>
     <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Pacco Identificativo</th>
      <th scope="col">Data</th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, key) in scratchAndWinsBought" :key="key" >
      <td>{{ scratchAndWin.name }}</td>
      <td>{{ scratchAndWin.pivot.tokenPackage }}</td>
      <td>{{  moment(scratchAndWin.pivot.created_at).format('D/M/Y') }}</td>

    </tr>
  </tbody >
  <div class="col-12 p-0 my-2 mx-0 row row_submit">
      <div class="col-6">
          <button  type="text" class="form-control w-100">Totale Vendite : {{ this.getTotalSold() }}</button>
    </div>
      <div class="col-6" >
          <button type="text" class='form-control w-100'>Guadagno Totale : {{ (this.getTotalSold() * 0.08).toFixed(2) }}</button>
      </div>
  </div>
  
</table>
</template>
<script>
export default {
    data(){
        return {
            scratchAndWinsBought : [],
        }
    },
    props : {
    },
    methods : {
        getScratchAndWinsSold()
        {
            axios
                .get('/api/contabilita/' + this.$parent.tobacco_shop.id + '/pacchi/venduti')
                .then(response => this.scratchAndWinsBought = response.data.reverse())
                .catch(error => console.log(error))
        },
        getTotalSold()
        {
          let moneyGot = 0
          for(let key in this.scratchAndWinsSold)
          {
              moneyGot += Math.abs( this.scratchAndWinsSold[key].total_quantity * this.scratchAndWinsSold[key][0].prize )
          }
          return moneyGot
        },
    },
    mounted()
    {
      this.getScratchAndWinsSold()
      this.$parent.comeBack = '/contabilizza/' + this.$parent.tobacco_shop.id
    },

}
</script>