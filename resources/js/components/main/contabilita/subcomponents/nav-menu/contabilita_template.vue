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
                <td>{{ Math.abs(scratchAndWin.total_money) }} 	&#8364;</td>
                <td>{{ Math.abs(scratchAndWin.total_quantity) }} 	</td>
                <td>
                    {{ Math.abs(scratchAndWin.total_money_earned.toFixed(2)) }}	&#8364;
                </td>
            </tr>
        </tbody>
        <div class="col-12 p-0 my-2 mx-0 row row_submit">
            <div class="col-5">
                <button type="text" class="form-control w-100">
                    Totale Vendite : {{ this.getTotalSold() }} &#8364;
                </button>
            </div>
            <div class="col-5">
                <button type="text" class="form-control w-100">
                    Guadagno Totale :
                    {{ (this.getTotalSold() * 0.08).toFixed(2) }} &#8364;
                </button>
            </div>
            <div class="col-2">
                <button
                    type="text"
                    class="form-control w-100"
                    data-toggle="modal"
                    data-target="#exampleModalCenter"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        fill="currentColor"
                        class="bi bi-bar-chart-line"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z"
                        />
                    </svg>
                </button>
            </div>
          
        </div>
        <!-- Modal -->
            <div
                class="modal fade"
                id="exampleModalCenter"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content chart_modal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title_nav">
                                Andamento Guadagno
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <line-chart :dateX="Object.keys(scratchAndWinsSold)" :dateY="Object.entries(this.scratchAndWinsSold).map(function(item){return item[1].total_money_earned})" ></line-chart>

                        </div>
                    </div>
                </div>
            </div>
    </table>
</template>
<script>
import LineChart from '../../charts/lineChart.vue';
export default {
  components : {LineChart},
    data() {
        return {
            scratchAndWinsSold: [],
        };
    },
    props: {
        scratch_and_wins_sold_api: Object
    },
    watch: {
        scratch_and_wins_sold_api: function() {
            this.scratchAndWinsSold = this.scratch_and_wins_sold_api;

        },
    },
    methods: {
        getScratchAndWinsSold() {
            axios
                .get(this.$parent.componentToOpen.parametres.route)
                .then(response => (this.scratchAndWinsSold = response.data))
                .catch(error => console.log(error));
        },
        getTotalSold() {
            let moneyGot = 0;
            for (let key in this.scratchAndWinsSold) {
                moneyGot += Math.abs(this.scratchAndWinsSold[key].total_money);
            }
            return moneyGot;
        },
        updateDatas(parametres) {
            this.scratchAndWinsSold = [];
            this.getScratchAndWinsSold();
        }
    },
    mounted() {
        if (this.scratch_and_wins_sold_api) {
            this.scratchAndWinsSold = this.scratch_and_wins_sold_api;
        } else {
            this.getScratchAndWinsSold();
            this.$parent.comeBack =
                "/contabilizza/" + this.$parent.tobacco_shop.id;
        }
        this.$root.$on("menuOptionChanged", this.updateDatas);
    }
};
</script>
