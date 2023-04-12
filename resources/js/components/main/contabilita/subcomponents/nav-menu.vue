<template>
 <div class="navbar-collapse" id="nav-menu">
           <link rel="stylesheet" href="/css/main/nav-menu.css">
    <div class="navbar-nav">
      <a class="nav-link lettersUp" v-for="(optionToSelect , index ) in optionsToSelect" :key="index" @click="openMenuOption(optionToSelect)">{{ optionToSelect.replaceAll('_',' ') }}</a>
    </div>
  </div>
  </template>
<script>
export default {
    data(){
        return{
        }
    },
    computed:
    {
        'optionsToSelect' : function(){
          let menu = ['contabilita_oggi','contabilita_quotidiana','seleziona_date','contabilita_mensile','magazzino','inserisci_nuovi_pacchi','aggiungi_dipendenti']
          
          /* se sei un dipendente */
          if(this.$parent.user_logged.id !== this.$parent.tobacco_shop.user_id)
          {
            return ['contabilita_oggi','magazzino','inserisci_nuovi_pacchi']
          }

          return menu

        }
    },
    methods : {
      openMenuOption(nameComponent)
      {
          let route
          if(nameComponent.indexOf('contabilita') != -1){
            route = nameComponent.split('_')
            nameComponent = 'contabilita_template'
            this.$parent.componentToOpen.parametres.route = '/api/' + route[0] + '/'+ this.$parent.tobacco_shop.id +'/' + route[1]
          }
          this.$root.$emit('menuOptionChanged',null) 
          this.$parent.componentToOpen.name = nameComponent
          this.$parent.nav_menu = !this.$parent.nav_menu

      }
    }
}
</script>