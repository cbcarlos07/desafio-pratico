export default {
    methods: {
        formatDate(date, lang = 'br'){
            if( lang == 'br' ){
                const arrDateDB = date.split('T')
                let arrDate = arrDateDB[0].split('-')
                return `${arrDate[2]}/${arrDate[1]}/${arrDate[0]}`
            }else{
                let arrDate = date.split('/')
                return `${arrDate[2]}-${arrDate[1]}-${arrDate[0]}`
            }
        },
        formatPrice(value) {
            const val = Number(value.replace(",", "."));
            if (!val) return '0,00';
            const valueString = val.toFixed(2).replace(".", ",");
            return valueString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        makeNumber(value){
            return Number(value.replace('R$ ','').replaceAll('.','').replace(',','.'))
        },
    }
}