<template>
 <div class="navbar-collapse" id="nav-menu">
           <link rel="stylesheet" href="/css/main/nav-menu.css">
    <div class="navbar-nav">
      <a class="nav-link lettersUp" v-for="(optionToSelect , index ) in optionsToSelect" :key="index">{{ optionToSelect.replaceAll('_',' ') }}</a>
    </div>
  </div>
  </template>
<script>
export default {
    data(){
        return{
          optionsToSelect : ['contabilità_quotidiana', 'contabilità_settimanale','contabilità_mensile','magazzino','inserisci_nuovi_pacchi','aggiungi_dipendenti']
        }
    }
}
</script>