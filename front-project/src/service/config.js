import axios from 'axios'
import base from './base'

const URL = base.url


console.log('base', URL);
const http = axios.create({
    baseURL: `${URL}`
})

export {http}