<template>
  
  	<div class="main">
		<v-card elevation="2" outlined height="70" color=""  >
			<h1>Listagem</h1>
		</v-card>

    	<v-container class="subtitle" >

			<v-card elevation="2" outlined height="70" color="" class="container" >
				Certifique-se que seu arquivo seja separado por ponto e vírgula (;).
			</v-card>

			<v-row style="margin-top: 12px">
				<v-col cols="12" md="10">
					<v-file-input  v-model="arquivo" truncate-length="15" outlined dense label="Anexar arquivo .json" @change="verificarArquivo" />
				</v-col>
				<v-col cols="12" md="2">
					<v-btn color="primary" :disabled="!arquivoValido" @click="enviarArquivo" :loading="carregarBotao">Enviar</v-btn>
				</v-col>

				<v-col cols="12" md="12">
					<v-data-table v-if="carregandoTabela" item-key="name" class="elevation-1" loading loading-text="Loading... Please wait" />
					<v-data-table v-if="!carregandoTabela" :headers="headers" :items="lista" >
						<template v-slot:[`item.id`]="{ item }">
							<span class="acao" @click="irParaEditar(item)">Edit</span>
							<span class="acao" @click="perguntaAntesDeRemove(item)">Delete</span>
						</template>
					</v-data-table>
				</v-col>
			</v-row>


		
			<v-snackbar  v-model="mostrarAlerta" :top="true"  :color="tipoMensagem" class="alerta">{{mensagemAlerta }} </v-snackbar>
		
    	</v-container>

		<pergunta :dialog="mostrarDialog" :title="textoDialog" @fechar="mostrarDialog = false" @confirmar="confirmarDelete"/>


  	</div>


</template>

<script>
import pergunta from './dialog.vue'
export default {
	components: {
		pergunta
	},
	data: () =>({
		carregandoTabela: true,
		mostrarDialog: false,
		textoDialog: '',
		carregarBotao: false,
		mostrarAlerta: false,
		tipoMensagem: 'success',
		mensagemAlerta: '',
		arquivoValido: false,
		headers: [
		{text: 'Title',value: 'title',align: 'left'},
		{text: 'Type',value: 'type',align: 'left'},
		{text: 'Rating',value: 'rating',align: 'left'},
		{text: 'Price',value: 'price',align: 'left'},
		{text: 'Created',value: 'created_at',align: 'left'},
		{text: 'Action',value: 'id',align: 'left'},
		],
		lista: [],
		arquivo: null,
		item: null
	}),
  	mounted() {
	  this.buscarDados()
  	},
  	methods: {
		irParaEditar(val){
			sessionStorage.setItem('id', val.id)
			this.$router.push({name: 'About'})
		},
		buscarDados(){
			this.$http.get('/products')
				.then(response => {
					this.carregandoTabela = false
					this.lista = response.data
				})
		},
		enviarArquivo(){
			this.arquivoValido = false
			this.carregarBotao  = true
			const formData = new FormData()
			formData.append('arquivo', this.arquivo)
			this.$http.post('/products', formData)
				.then(response => {
					const {status, msg } = response.data
					this.tipoMensagem = 'error'
					if( status ){
						this.tipoMensagem = 'success'
					}
					this.acaoAlerta(this.tipoMensagem, msg)
					this.carregarBotao  = false
					this.arquivo = null
					this.buscarDados()

				})
		},
		acaoAlerta(tipo, msg){
	
			this.tipoMensagem = tipo
			this.mensagemAlerta = msg
			this.mostrarAlerta = true
		
	
		},
		verificarArquivo(){
			
			const ext = this.arquivo.name.substr( this.arquivo.name.length - 3,  this.arquivo.name.length)
			
			this.arquivoValido = false
			if( ext === 'csv' ){			
				this.arquivoValido = true
			}

			console.log('arquivo valido');

		},

		perguntaAntesDeRemove(item){
			this.item = item
			console.log('perguntaAntesDeRemove');
			this.mostrarDialog = true
			this.textoDialog = `Deseja realmente remover <strong>${item.title}</strong>?`
		},

		confirmarDelete(){
			this.lista = []
			this.mostrarDialog = false
			this.$http.delete(`/products/${this.item.id}`)
				.then(response => {
					const { status, msg } = response.data
					let tipo = 'error'
					if( status ){
						tipo = 'success'
					}
					this.acaoAlerta(tipo, msg)
					
					this.buscarDados()
				})
		}
  	}
}

</script>


<style scoped>
  .main{
    padding-left: 20px; 
    padding-right: 15px
  }

  .title{
    margin-top: 15px;
  }
  .container{
    padding: 10px;
  }
  .subtitle{
    width: 700px; 
    margin-left: auto;
    margin-right: auto;
  }
  .alerta{
	  margin-bottom: 12px;
	  position: absolute;
  }

  .acao{
	  cursor: pointer;
  }
 

</style>
