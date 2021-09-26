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
      scratch_and_wins_sold_api : Object,
    },
    watch : {
      scratch_and_wins_sold_api : function(){
        this.scratchAndWinsSold = this.scratch_and_wins_sold_api ;
      },

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
              moneyGot += Math.abs( this.scratchAndWinsSold[key].total_money )
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
      if( this.scratch_and_wins_sold_api )
      {
        this.scratchAndWinsSold = this.scratch_and_wins_sold_api

      }else
      {
        this.getScratchAndWinsSold()
        this.$parent.comeBack = '/contabilizza/' + this.$parent.tobacco_shop.id
      }
      this.$root.$on('menuOptionChanged',this.updateDatas)
    },

}
</script>