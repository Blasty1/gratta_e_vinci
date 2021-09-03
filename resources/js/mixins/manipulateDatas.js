export const manipulateDatas = {

        methods : {
            allDataIsBeenInserted(dataToCheck)
            {
                for( let singleData of dataToCheck)
                {
                    if( this[singleData].value.length == 0 ) this[singleData].error = "Compila questo campo"
                }
            },

            cleanInputErrors(dataToCheck)
            {
                for( let singleData of dataToCheck)
                {
                    this[singleData].error = false
                }
            },

            thereAreErrors(dataToCheck)
            {
                for( let singleData of dataToCheck)
                {
                    if( this[singleData].error ) return true 
                }
            },
            getDatasFormatted(dataToCheck)
            {
                let objectOfDatas = {}

                for( let singleData of dataToCheck)
                {
                    objectOfDatas[singleData] = this[singleData].value
                }
                return objectOfDatas
            },
            getErrorsFromBackEnd(errors, thisClass)
            {   
                for( let key in errors.errors )
                {
                    thisClass[key].error = errors.errors[key][0]
                }
            },
        }
}