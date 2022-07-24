<template>
<div>
    <ul class="p-0 overflow-auto" id="tobaccoShopsToDelete">
        <li v-for="tobacco_shop in tobacco_shops" :key="tobacco_shop.id">
            <h5>
                    {{tobacco_shop.name}}
            </h5>
            <button type="button" class="btn btn-danger" data-toggle="modal" @click="submitData(tobacco_shop)" data-target="#exampleModal">Elimina Definitivamente</button>
        </li>
    </ul>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalAlert">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Elimina : {{tobacco_shop_selected.name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        E' stata appena inviata un email al tuo account con un link che ti servirà per confermare la totale eliminazione della tua attività.<br>
        Una volta confermata l'eliminazione non sarà possibile recuperare i dati,se hai cambiato idea ignora l'email.
      </div>
    </div>
  </div>
</div>

</div>
</template>

<script>
export default {
    data() {
        return {
            tobacco_shop_selected : {}
        };
    },
    props : {
        tobacco_shops : Array
    },
    methods : {
        submitData(tobacco_shop)
        {
            axios
                .get('/api/'+ tobacco_shop.id + '/deleteTobaccoShop/sendEmail')
                .then(() => this.tobacco_shop_selected = tobacco_shop)
                .catch(error => console.log(error))

        }
    }
};
</script>
