<template>
     <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Costo totale</th>
      <th scope="col">Quantità</th>
      <th scope="col">Guadagno</th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, key) in scratchAndWinsSold" :key="key">
      <td>{{ key }}</td>
      <td>{{ Math.abs( scratchAndWin.total_money) }}</td>
      <td>{{  Math.abs( scratchAndWin.total_quantity)  }}</td>
      <td>{{ Math.abs( scratchAndWin.total_money_earned.toFixed(2)) }}</td>

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
            scratchAndWinsSold : [],
        }
    },
    props : {
    },
    methods : {
        getScratchAndWinsSold()
        {
            axios
                .get(this.$parent.componentToOpen.parametres.route)
                .then(response => this.scratchAndWinsSold = response.data)
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
        updateDatas(parametres)
        {
          this.scratchAndWinsSold = []
          this.getScratchAndWinsSold()
        }
    },
    mounted()
    {
      this.getScratchAndWinsSold()
      this.$root.$on('menuOptionChanged',this.updateDatas)
      this.$parent.comeBack = '/contabilizza/' + this.$parent.tobacco_shop.id
    },

}
</script>