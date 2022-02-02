<template>
  	<div>
		<v-overlay :value="estaCarregando">
			<v-progress-circular indeterminate size="64"></v-progress-circular>
			{{ textoCarregando  }}
		</v-overlay>  
    	<h1>Atualizar Produto</h1>
		<v-container>
			<v-form v-model="formValid">
				<v-row no-gutters>
					<v-col cols="12" md="6">
						<v-text-field v-model="produto.title" outlined dense label="Title" class="px-2" :rules="[v => !!v || 'Title is required']"/>
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field v-model="produto.type" outlined dense label="Type" />
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field v-model="produto.description" outlined dense label="Description" class="px-2" />
					</v-col>
					<v-col cols="12" md="6">
						<v-text-field v-model.lazy="price" outlined dense label="Price" v-money="money" />
					</v-col>
					<v-col cols="12" md="12">
						Rating
						<v-rating  empty-icon="fa-star-o" full-icon="fa-star" v-model="produto.rating" background-color="indigo lighten-3" color="primary" large />
					</v-col>

				</v-row>
					<v-divider />
					<br>
					<v-row no-gutters>
						<v-col cols="12" md="6" align="right"  class="px-2">
							<v-btn class="px-2" color="error" @click="$router.go(-1)">
								<v-icon small>fa-reply</v-icon>
								&nbsp;
								Back
							</v-btn>
						</v-col>
						<v-col cols="12" md="6" align="left" class="px-2" >
							<v-btn color="primary" :disabled="!formValid" :loading="carregarBotao" @click="atualizar">
								<v-icon small>fa-save</v-icon>
								&nbsp;
								Submit
							</v-btn>
						</v-col>

					</v-row>

			</v-form>
		</v-container>
		<v-snackbar  v-model="mostrarAlerta" :top="true"  :color="tipoMensagem" class="alerta">{{mensagemAlerta }} </v-snackbar>
  	</div>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
	components: {
		StarRating
	},
	data: ()=>({
		mostrarAlerta: false,
		tipoMensagem: '',
		mensagemAlerta: '',
		estaCarregando: true,
		carregarBotao: false,
		textoCarregando: 'Aguarde enquanto buscamos as informações',
		formValid: false,
		produto: {rating: 1},
		price: 0,
		money: {
          decimal: ",",
          thousands: ".",
          prefix: "R$ ",
          suffix: "",
          precision: 2,
          unmaskedVar: null 
        }
	}),
	created(){
		this.buscarPorId()
	},
	methods: {
		buscarPorId(){
			const id = sessionStorage.getItem('id')
			this.$http.get(`/products/${id}`)
				.then(response => {
					this.estaCarregando = false
					const {price} = response.data
					this.price = price
					this.produto = response.data
				})
		},

		atualizar(){
			const id = this.produto.id
			delete this.produto.id
			this.carregarBotao = true
			this.produto.price = Number( this.price.replace('R$ ','').replace('.','').replace(',', '.') )
			this.$http.put(`/products/${id}`, this.produto)
				.then(response => {
					this.carregarBotao = false
					const {status, msg} = response.data
						this.mensagemAlerta = msg
					if( status ){
						this.tipoMensagem = 'success'
					}else{
						this.tipoMensagem = 'error'
					}
					this.mostrarAlerta = true
				})
		}
	}
}
</script>

