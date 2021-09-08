<template>
     <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">Nome E Cognome</th>
      <th scope="col">GV venduti</th>
      <th scope="col">Data Di Aggiunta</th>
      <th></th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(employee, key) in employees" :key="key" >
      <td>{{ employee.name + ' ' + employee.surname}}</td>
      <td>{{Math.abs(employee.scratchAndWinSold) }}</td>
      <td>{{  moment(employee.pivot.created_at).format('D/M/Y') }}</td>
      <td @click="deleteEmployee(key)">&times</td>

    </tr>
  </tbody >
  <div class="col-12 p-0 my-2 mx-0 row row_submit">
      <div class="col-10">
          <input  type="email" :class="{'form-control w-100' : true , 'is-invalid' : email.error}" :placeholder="this.email.error || 'inserisci l\'email del dipendente'" v-model="email.value"/>
    </div>
      <div class="col-2" >
          <button type="text" class='form-control w-100' @click.prevent="submitData()">Invia</button>
      </div>
  </div>
  
</table>
</template>
<script>
import { manipulateDatas } from "../../../../../mixins/manipulateDatas.js"
export default {
    mixins : [manipulateDatas],
    data(){
        return {
            employees : [],
            email : {
                value : '',
                error : false
            },
            dataToSubmit : ['email']
        }
    },
    props : {
    },
    methods : {
        getEmployees()
        {
            axios
                .get('/api/contabilita/' + this.$parent.tobacco_shop.id + '/employees')
                .then(response => this.employees = response.data.reverse())
                .catch(error => console.log(error))
        },
        deleteEmployeeFrontEnd(keyOfArrayWhereAreEmployees)
        {
            this.employees.splice(keyOfArrayWhereAreEmployees,1)
        },
        deleteEmployee(keyOfArrayWhereAreEmployees)
        {
            axios
                .delete('/api/contabilita/' + this.$parent.tobacco_shop.id + '/employees/' + this.employees[keyOfArrayWhereAreEmployees].id)
                .then(response => this.deleteEmployeeFrontEnd(keyOfArrayWhereAreEmployees))
                .catch(errorName => console.log(errorName))
        },

        submitDataFrontEnd(newEmployee)
        {
            if( newEmployee ) this.employees.unshift(newEmployee)
            this.email.value = ''
        },
        submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if( this.email.value.indexOf('@') == -1) this.email.error = 'Inserisci un email corretta'
            if( this.thereAreErrors(this.dataToSubmit) ) return 
            axios
                .post('/api/contabilita/' + this.$parent.tobacco_shop.id + '/employee/add' , this.getDatasFormatted(this.dataToSubmit))
                .then(response => (this.submitDataFrontEnd(response.data) ))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    },
    mounted()
    {
      this.getEmployees()
      this.$parent.comeBack = '/contabilizza/' + this.$parent.tobacco_shop.id
    },

}
</script>