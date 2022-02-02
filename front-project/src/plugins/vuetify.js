
import Vue from 'vue'
import Vuetify,{} from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
import pt from 'vuetify/lib/locale/pt'
const opts = {
    theme: { 
        themes: {
            light: {
                primary: '#3f51b5',
                secondary: '#b0bec5',
                accent: '#8c9eff',
                error: '#b71c1c',
            },
          },
     },
    lang: {
        locales: {pt},
        current: 'pt'
    }
}

export default new Vuetify(opts)