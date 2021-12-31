<template>
    <table class="table" id="contabilita_table">
  <thead>
    <tr>
      <th scope="col">GV Nome</th>
      <th scope="col">Prezzo</th>
      <th scope="col">Quantità</th>
      <th scope="col">Venduto da</th>
       <th scope="col">Orario</th>
       <th v-if="$parent.user_logged.id === $parent.tobacco_shop.user_id" ></th>
    </tr>
  </thead>
  <tbody ref="table">
    <tr v-for="(scratchAndWin, index) in scratchAndWinSold" :key="index"  :class="{ 'itemsExceptFirst' :  index != 0, 'changeBGRow' : index <= newItem.length ? newItem[index] : false }" >
      <td scope="row">{{ scratchAndWin.name}}</td>
      <td>{{ Math.abs( scratchAndWin.prize * scratchAndWin.pivot.quantity) }}</td>
      <td>{{  Math.abs(scratchAndWin.pivot.quantity)  }}</td>
      <td>{{ ( scratchAndWin.user &&  scratchAndWin.user.name ) || 'Gestore' }}</td>
      <td>{{ moment(scratchAndWin.pivot.created_at).format('LT')  }}</td>
      <td @click="deleteScratchAndWinSold(scratchAndWin.pivot.id, index)" v-if="$parent.user_logged.id === $parent.tobacco_shop.user_id" role="button">&times</td>
    </tr>
  </tbody >
  <div class="col-12 p-0 my-2 mx-0 row row_submit">
      <div class="col-6" :class="{'color_placeholder_red' : token.error}">
          <input ref="tokenInput" type="text" :class="{'form-control w-100' : true, 'is-invalid' : token.error }" id="validationServer01" v-model="token.value" aria-describedby="validationServer03Feedback"  :placeholder="token.error || 'Inserisci il codice seriale del GV' " required autofocus>
    </div>
      <div class="col-2" :class="{'color_placeholder_red' : quantity.error}">
          <input type="number" :class="{'form-control w-100' : true, 'is-invalid' : quantity.error}" id="validationServer03" v-model.number="quantity.value" aria-describedby="validationServer02Feedback" required>
            <div id="validationServer02Feedback" class="invalid-feedback">
                {{quantity.error}}
    </div></div>
      <div class="col-4"><button class="w-100" @click.prevent="submitData()">Invia</button></div>
  </div>
  
</table>
</template>
<script>
import { manipulateDatas } from "../../../../mixins/manipulateDatas.js"

export default {
  mixins : [ manipulateDatas ],
    data(){
        return {
            scratchAndWinSold : [],
            token : {
                value : '',
                error : false 
            },
            quantity : {
                value : 1,
                error : false
            },
            newItem : [],
            dataToSubmit : ['token','quantity'],
            newEntry : false,
        }
    },
    watch : {
        'token.value' : function(){
            if(this.token.value.length ==  16) this.submitData()
        }
    },
    methods : {
        getScratchAndWinSold()
        {
            axios
                .get('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins')
                .then(response => this.scratchAndWinSold = response.data.reverse())
                .catch(error => console.log(error))
        },
        deleteScratchAndWinSoldFrontEnd(positionOfItemToDelete)
        {
            this.scratchAndWinSold.splice(positionOfItemToDelete,1)
            this.$nextTick(() => this.$refs.tokenInput.focus())        
        },
        deleteScratchAndWinSold(idItemsToDelete, positionInArray)
        {
            axios
                .delete('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins/' + idItemsToDelete + '/delete')
                .then(response => this.deleteScratchAndWinSoldFrontEnd(positionInArray))
                .catch(error => console.log(error.data))

        },
        submitDataFrontEnd(newScratchAndWinSold)
        {
            this.scratchAndWinSold.unshift(newScratchAndWinSold)
            this.token.value = ""
            this.quantity.value = 1
            var snd = new  Audio("data:audio/wav;base64,//uQRAAAAWMSLwUIYAAsYkXgoQwAEaYLWfkWgAI0wWs/ItAAAGDgYtAgAyN+QWaAAihwMWm4G8QQRDiMcCBcH3Cc+CDv/7xA4Tvh9Rz/y8QADBwMWgQAZG/ILNAARQ4GLTcDeIIIhxGOBAuD7hOfBB3/94gcJ3w+o5/5eIAIAAAVwWgQAVQ2ORaIQwEMAJiDg95G4nQL7mQVWI6GwRcfsZAcsKkJvxgxEjzFUgfHoSQ9Qq7KNwqHwuB13MA4a1q/DmBrHgPcmjiGoh//EwC5nGPEmS4RcfkVKOhJf+WOgoxJclFz3kgn//dBA+ya1GhurNn8zb//9NNutNuhz31f////9vt///z+IdAEAAAK4LQIAKobHItEIYCGAExBwe8jcToF9zIKrEdDYIuP2MgOWFSE34wYiR5iqQPj0JIeoVdlG4VD4XA67mAcNa1fhzA1jwHuTRxDUQ//iYBczjHiTJcIuPyKlHQkv/LHQUYkuSi57yQT//uggfZNajQ3Vmz+Zt//+mm3Wm3Q576v////+32///5/EOgAAADVghQAAAAA//uQZAUAB1WI0PZugAAAAAoQwAAAEk3nRd2qAAAAACiDgAAAAAAABCqEEQRLCgwpBGMlJkIz8jKhGvj4k6jzRnqasNKIeoh5gI7BJaC1A1AoNBjJgbyApVS4IDlZgDU5WUAxEKDNmmALHzZp0Fkz1FMTmGFl1FMEyodIavcCAUHDWrKAIA4aa2oCgILEBupZgHvAhEBcZ6joQBxS76AgccrFlczBvKLC0QI2cBoCFvfTDAo7eoOQInqDPBtvrDEZBNYN5xwNwxQRfw8ZQ5wQVLvO8OYU+mHvFLlDh05Mdg7BT6YrRPpCBznMB2r//xKJjyyOh+cImr2/4doscwD6neZjuZR4AgAABYAAAABy1xcdQtxYBYYZdifkUDgzzXaXn98Z0oi9ILU5mBjFANmRwlVJ3/6jYDAmxaiDG3/6xjQQCCKkRb/6kg/wW+kSJ5//rLobkLSiKmqP/0ikJuDaSaSf/6JiLYLEYnW/+kXg1WRVJL/9EmQ1YZIsv/6Qzwy5qk7/+tEU0nkls3/zIUMPKNX/6yZLf+kFgAfgGyLFAUwY//uQZAUABcd5UiNPVXAAAApAAAAAE0VZQKw9ISAAACgAAAAAVQIygIElVrFkBS+Jhi+EAuu+lKAkYUEIsmEAEoMeDmCETMvfSHTGkF5RWH7kz/ESHWPAq/kcCRhqBtMdokPdM7vil7RG98A2sc7zO6ZvTdM7pmOUAZTnJW+NXxqmd41dqJ6mLTXxrPpnV8avaIf5SvL7pndPvPpndJR9Kuu8fePvuiuhorgWjp7Mf/PRjxcFCPDkW31srioCExivv9lcwKEaHsf/7ow2Fl1T/9RkXgEhYElAoCLFtMArxwivDJJ+bR1HTKJdlEoTELCIqgEwVGSQ+hIm0NbK8WXcTEI0UPoa2NbG4y2K00JEWbZavJXkYaqo9CRHS55FcZTjKEk3NKoCYUnSQ0rWxrZbFKbKIhOKPZe1cJKzZSaQrIyULHDZmV5K4xySsDRKWOruanGtjLJXFEmwaIbDLX0hIPBUQPVFVkQkDoUNfSoDgQGKPekoxeGzA4DUvnn4bxzcZrtJyipKfPNy5w+9lnXwgqsiyHNeSVpemw4bWb9psYeq//uQZBoABQt4yMVxYAIAAAkQoAAAHvYpL5m6AAgAACXDAAAAD59jblTirQe9upFsmZbpMudy7Lz1X1DYsxOOSWpfPqNX2WqktK0DMvuGwlbNj44TleLPQ+Gsfb+GOWOKJoIrWb3cIMeeON6lz2umTqMXV8Mj30yWPpjoSa9ujK8SyeJP5y5mOW1D6hvLepeveEAEDo0mgCRClOEgANv3B9a6fikgUSu/DmAMATrGx7nng5p5iimPNZsfQLYB2sDLIkzRKZOHGAaUyDcpFBSLG9MCQALgAIgQs2YunOszLSAyQYPVC2YdGGeHD2dTdJk1pAHGAWDjnkcLKFymS3RQZTInzySoBwMG0QueC3gMsCEYxUqlrcxK6k1LQQcsmyYeQPdC2YfuGPASCBkcVMQQqpVJshui1tkXQJQV0OXGAZMXSOEEBRirXbVRQW7ugq7IM7rPWSZyDlM3IuNEkxzCOJ0ny2ThNkyRai1b6ev//3dzNGzNb//4uAvHT5sURcZCFcuKLhOFs8mLAAEAt4UWAAIABAAAAAB4qbHo0tIjVkUU//uQZAwABfSFz3ZqQAAAAAngwAAAE1HjMp2qAAAAACZDgAAAD5UkTE1UgZEUExqYynN1qZvqIOREEFmBcJQkwdxiFtw0qEOkGYfRDifBui9MQg4QAHAqWtAWHoCxu1Yf4VfWLPIM2mHDFsbQEVGwyqQoQcwnfHeIkNt9YnkiaS1oizycqJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=")  
            snd.play()
            this.newItem.unshift(true)
            function setVariableFalse(className)
            {
                className.newItem.pop()
            }
            setTimeout(setVariableFalse,2000,this)

            this.$nextTick(() => this.$refs.tokenInput.focus())        
        },
        submitData()
        {
            this.cleanInputErrors(this.dataToSubmit)
            this.allDataIsBeenInserted(this.dataToSubmit)
            if( this.thereAreErrors(this.dataToSubmit) ) return 
            this.quantity.value = - this.quantity.value
            axios
                .post('/api/contabilizza/' + this.$parent.tobacco_shop.id + '/scratchAndWins/store' , this.getDatasFormatted(this.dataToSubmit))
                .then(response => (this.submitDataFrontEnd(response.data) ))
                .catch(errors => this.getErrorsFromBackEnd(errors.response.data, this))
        }
    },
    mounted(){
        this.getScratchAndWinSold()
        this.comeBack = '/dashboard'
    }
}
</script>